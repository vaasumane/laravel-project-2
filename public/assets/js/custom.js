function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function deleteAllCookies() {
    const cookies = document.cookie.split(";");

    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;";
    }
    setTimeout(() => {
        window.location.href = base_url;
    },2000);
}

$(document).ready(function () {
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();
        const formdata = new FormData($("#loginForm")[0]);
        $.ajax({
            url: base_url + "validate_credentials",
            method: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    setCookie("username", response.data.username, 1);
                    setCookie("email", response.data.email, 1);
                    setCookie("authToken", response.authToken, 1);
                    setCookie("role", response.data.role_id, 1);
                    setTimeout(function () {
                        window.location.href = base_url + "dashboard";
                    }, 3000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                toastr.error(error.message);
            },
        });
    });
    $("#btnAddEmployee").click(function (e) {
        e.preventDefault();
        const formdata = new FormData($("#addEmployee")[0]);
        $.ajax({
            url: base_url + "api/v1/employee/add-employee",
            headers: {
                authToken: getCookie("authToken"),
            },
            method: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    $("#employeeModel").modal("hide");
                    $("#addEmployee")[0].reset();
                    $("#employee-table").DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (error) {
                console.log(error);
                toastr.error(error?.responseJSON?.message);
            },
        });
    });
    $("body").on("click", ".emp-delete", function () {
        id = $(this).attr("data-id");
        swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (result) {
            console.log(result);
            if (result) {
                $.ajax({
                    url: base_url + "api/v1/employee/delete-employee",
                    headers: {
                        authToken: getCookie("authToken"),
                    },
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success(response.message);
                            $("#employee-table").DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (error) {
                        toastr.error(error.message);
                    },
                });
            }
        });
    });
    $("body").on("click", ".edit-emp", function () {
        id = $(this).attr("data-id");
        $.ajax({
            url: base_url + "api/v1/employee/get-employee",
            headers: {
                authToken: getCookie("authToken"),
            },
            method: "POST",
            dataType: "json",
            data: {
                id: id,
            },
            success: function (response) {
                console.log(response);
                if (
                    response.status &&
                    response.data &&
                    response.data.length > 0
                ) {
                    $("#editname").val(response.data?.[0].name);
                    $("#editusername").val(response.data?.[0].username);
                    $("#editemail").val(response.data?.[0].email);
                    $("#editid").val(id);
                    $("#editdesignation_id")
                        .find(
                            "option[value='" +
                                response.data?.[0].designation_id +
                                "']"
                        )
                        .attr("selected", true);
                    $("#EditemployeeModel").modal("show");
                } else {
                }
            },
            error: function (error) {
                toastr.error(error.message);
            },
        });
    });
    $("#EditEmployee").click(function (e) {
        e.preventDefault();
        const formdata = new FormData($("#EditEmployeeForm")[0]);
        $.ajax({
            url: base_url + "api/v1/employee/edit-employee",
            headers: {
                authToken: getCookie("authToken"),
            },
            method: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    $("#EditemployeeModel").modal("hide");
                    $("#EditEmployeeForm")[0].reset();
                    $("#employee-table").DataTable().ajax.reload();
                } else {
                    toastr.error(error?.responseJSON?.message);
                }
            },
            error: function (error) {
                toastr.error(error.message);
            },
        });
    });
    if ($("#employee-table").length) {
        $("#employee-table").DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            ajax: {
                url: base_url + "api/v1/employee/get-employee",
                type: "POST",
                headers: {
                    authToken: getCookie("authToken"),
                },
            },

            order: [[0, "desc"]],
            columnDefs: [{ orderable: false, targets: [1, 2, 3, 4, 5] }],
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "username" },
                { data: "email" },
                { data: "designation_name" },
                { data: "action" },
            ],
        });
    }
});
