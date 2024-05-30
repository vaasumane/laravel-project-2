@extends('layout.frontend')
@section('content')
<div>
    <div class="container">
        <div class="py-3 d-flex justify-content-between">
            <h2>Employee List </h2>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeModel">
                    Add Employee
                </button>
            </div>
        </div>
        <div>
            <table class="table" id="employee-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>email</th>
                        <th>Designation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="employeeModel">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployee">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="designation_id" class="form-label">Designation</label>

                            <select class="form-select form-select-md mb-3" id="designation_id" name="designation_id" aria-label=".form-select-lg example">

                                @foreach ($designation as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->designation_name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button type="button" class="btn btn-primary" id="btnAddEmployee">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="EditemployeeModel">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="EditEmployeeForm">
                        <div class="mb-3">
                            <label for="editname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editname" name="name" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="editusername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editusername" name="username" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="editemail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="editemail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="editpassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editpassword" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="editdesignation_id" class="form-label">Designation</label>

                            <select class="form-select form-select-md mb-3" name="designation_id" id="editdesignation_id">

                                @foreach ($designation as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->designation_name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <input type="hidden" name="id" id="editid">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button type="button" class="btn btn-primary" id="EditEmployee">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection