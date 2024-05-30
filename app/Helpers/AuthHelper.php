<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

if (!function_exists('generateAuthToken')) {
    function generateAuthToken($user)
    {
        $key = config("app.enc_key");
        $payload = [
            'exp' => time() + (int) config('app.auth_token_expire_time'),
            'iat' => $now = time(),
            'jti' => md5(($now) . mt_rand()),
            'username' => $user->username,
            'email' => $user->email,
            'user_id' => $user->id
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}

if (!function_exists('registerUsers')) {
    function registerUsers($request,$role_id)
    {
        try{
            DB::beginTransaction();
            $userDetails = new User();
            $userDetails->username = $request->username;
            $userDetails->name = $request->name;
            $userDetails->email = $request->email;
            $userDetails->password = Hash::make($request->password);
            $userDetails->role_id = $role_id;
            $userDetails->save();
            DB::commit();
            $response = ['type'=>'success','status'=>true,'code'=>200,'data'=>$userDetails,'message'=>'User registered successfully'];
            return $response;

        }catch(\Exception $e){
            DB::rollback();
            Log::error("register users error".$e->getMessage().' '.$e->getLine());
            return ['type'=>'error','status'=>false,'code'=>500,'message'=>'Error while processing'];

        }
    }
}
