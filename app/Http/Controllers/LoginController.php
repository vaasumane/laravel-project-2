<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index(){
        $data["page"] = "login";
        return view('login', $data);
    }
    public function profile_setting(){
        $data["page"] = "profile-setting";
        return view('welcome1', $data);
    }
    public function validate_credentials(LoginRequest $request){
        try{
            DB::beginTransaction();
            $user = User::where("username",$request->username)->first();
            
            if($user){
    
                if(Hash::check($request->password,$user->password)){
                    $authToken = generateAuthToken($user);
                    $data["authToken"] = $user->authToken;
                    return response()->json(['type'=>'success','status'=>true,'code'=>'200','message'=>"Login successful",'data'=>$user,'authToken'=>$authToken]);
                }else{
                    return response()->json(['type' => 'error','status' => false ,'code'=>'200','message' => 'Incorrect Password']);
                }

            }else{
                return response()->json(['type' => 'error','status' => false ,'code'=>'200','message' => 'User does not exist']);
            }


        }catch(\Exception $e){
            DB::rollback();
            Log::info("Sign In error: " . $e->getMessage().$e->getLine());
            return response()->json(['type' => 'error','status' => false ,'code'=>'200','message' => 'Error while processing']);

        }
    }
}
