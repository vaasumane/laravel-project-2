<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDesignation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (isset($_COOKIE["authToken"])) {
            $user = User::where("username", $_COOKIE["username"])->first();
            if ($user->role_id == 1) {
                $getDesignation = EmployeeDesignation::all();
                $data["page"] = "employee-list";
                $data["designation"] = $getDesignation;
                return view("employee_list", $data);
            } else {
                return redirect("/profile-setting");
            }
        } else {
            return redirect("/");
        }
    }
}
