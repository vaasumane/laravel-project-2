<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->hasHeader("authToken")){
            $authToken = $request->header("authToken");
            try{
                $decoded = JWT::decode($authToken,new Key(config('app.enc_key'),'HS256'));
                $user = User::where("id",$decoded->user_id)->first();
                if ($user) {
                    $request->attributes->add(['user' => $user]);
                    return $next($request);
                } else {
                    return response()->json(['type' => 'error', 'code' => 200, 'status' => false, "redirect" => true, 'message' => 'User is not found', 'toast' => true]);
                }
            }catch(\Exception $e){
                return response()->json(['type'=>'error', 'status'=>false,'code'=>500,'message'=>'Token is invalid or broken']);
            }
        }
        return response()->json(['type'=>'error', 'status'=>false,'code'=>500,'message'=>'Unauthorized']);
    }
}
