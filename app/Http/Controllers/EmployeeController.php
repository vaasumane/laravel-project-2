<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEmployeeRequest;
use App\Models\EmployeeDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function CreateEmployee(AddEmployeeRequest $request)
    {
        try {
            $user = $request->attributes->get("user");

            DB::beginTransaction();
            $CreateUser = registerUsers($request, 2);

            if ($CreateUser && $CreateUser["status"]) {
                $employee = new EmployeeDetails();
                $employee->company_owner_id = $user->id;
                $employee->user_id = $CreateUser["data"]["id"];
                $employee->designation_id = $request->designation_id;
                $employee->save();
                DB::commit();
                return response()->json(['type' => 'success', 'status' => true, 'code' => 200, 'data' => $employee, 'message' => 'Employee registered successfully']);
            } else {
                return response()->json($CreateUser);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Add employee error " . $e->getMessage() . ' ' . $e->getLine());
            return response()->json(['type' => 'error', 'status' => false, 'code' => 500, 'message' => 'Error while processing']);
        }
    }
    public function UpdateEmployee(Request $request)
    {
        try {
            $user = $request->attributes->get("user");
            DB::beginTransaction();
            $getemployee = EmployeeDetails::where("id", $request->id)->first();
            $getUser = User::where("id", $getemployee->user_id)->first();
            if (isset($request->name)) {
                $getUser->name = $request->name;
            }
            if (isset($request->email)) {
                $getUser->email = $request->email;
            }
            if (isset($request->username)) {
                $getUser->username = $request->username;
            }
            if (isset($request->password)) {
                $getUser->password = Hash::make($request->password);
            }
            $getUser->save();
            if (isset($request->designation_id)) {
                $getemployee->designation_id = $request->designation_id;
            }
            $getemployee->save();

            DB::commit();
            return response()->json(['type' => 'success', 'status' => true, 'code' => 200, 'data' => $getemployee, 'message' => 'Employee registered successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Add employee error " . $e->getMessage() . ' ' . $e->getLine());
            return response()->json(['type' => 'error', 'status' => false, 'code' => 500, 'message' => 'Error while processing']);
        }
    }
    public function DeleteEmployee(Request $request)
    {
        try {
            $getemployee = EmployeeDetails::where("id", $request->id)->first();
            if ($getemployee) {
                $getemployee->delete();
                $getUser = User::where("id", $getemployee->user_id)->first();
                $getUser->delete();
                return response()->json(['type' => 'success', 'status' => true, 'code' => 200, 'message' => 'Employee Deleted successfully']);
            } else {
                return response()->json(['type' => 'error', 'status' => false, 'code' => 200, 'message' => 'Invalid employee']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Delete employee error " . $e->getMessage() . ' ' . $e->getLine());
            return response()->json(['type' => 'error', 'status' => false, 'code' => 500, 'message' => 'Error while processing']);
        }
    }
    public function GetEmployee(Request $request)
    {
        try {
            $user = $request->attributes->get("user");
            DB::beginTransaction();
            DB::enableQueryLog();
            $employeeQuery = EmployeeDetails::join("users", "users.id", "=", "employee_details.user_id")
                ->join("employee_designation", "employee_designation.id", "=", "employee_details.designation_id")
                ->select([
                    "employee_details.*",
                    "users.username",
                    "users.name",
                    "users.email",
                    "employee_designation.designation_name"
                ])
                ->where("employee_details.company_owner_id", $user->id);

            if (isset($request->id)) {
                $employeeQuery->where("employee_details.id", $request->id);
            } else {
                if (isset($request->search) && isset($request->search["value"])) {
                    $search = $request->search["value"];
                    $employeeQuery->where(function ($query) use ($search) {
                        $query->where("users.name", "like", "%{$search}%")
                            ->orWhere("users.email", "like", "%{$search}%");
                    });
                }
                if (isset($request->start)) {
                    $employeeQuery->skip($request->start);
                }
                if (isset($request->length)) {
                    $employeeQuery->take($request->length);
                }
                $employeeQuery->orderBy("employee_details.id","desc");

            }

            $employeeList = $employeeQuery->get();
            $recordsTotal = $employeeQuery->count();
            $recordsFiltered  = EmployeeDetails::where("company_owner_id", $user->id)->count();

            $result = array();
            $i=1;
            if (!empty($employeeList)) {
                foreach ($employeeList as $key => $value) {
                    $value->action = '<div class="d-flex justify-content-between"><a href="#" class="edit-emp" data-id="' . $value->id . '">Edit</a><a href="#" class="emp-delete" data-id="' . $value->id . '">Delete</a></div>';
                    $value->id = $i;
                    $i++;
                    $result[] = $value;
                }
                $response["status"] =  true;
                $response["data"] =  $result;
                $response["draw"] = intval($request->draw);
                $response["recordsFiltered"] =  $recordsFiltered;
                $response["recordsTotal"] =  $recordsTotal;
            } else {

                $response["status"] =  false;
                $response["data"] =  array();
                $response["draw"] = intval($request->draw);
                $response["recordsFiltered"] =  $recordsFiltered;
                $response["recordsTotal"] =  $recordsTotal;
            }
            echo json_encode($response);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Get employee error " . $e->getMessage() . ' ' . $e->getLine());
            return response()->json(['type' => 'error', 'status' => false, 'code' => 500, 'message' => 'Error while processing']);
        }
    }
}
