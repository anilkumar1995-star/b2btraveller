<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;

class ApiCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($post, Closure $next)
    {   
        if (!\Request::is('api/getip') && !\Request::is('api/gateway/update/*') && !\Request::is('api/paysprint/*') && !\Request::is('api/paysprint/agent/onboard') && !\Request::is('api/getbal/*') && !\Request::is('api/callback/*') && !\Request::is('api/checkaeps/*') && !\Request::is('api/android/*') && !\Request::is('api/runpaisa/callback/*')) {
            if (!$post->has('token')) {
                return response()->json(['statuscode' => 'ERR', 'status' => 'ERR', 'message' => 'Invalid api token']);
            }

            // $user = \App\Models\Apitoken::where('ip', $post->ip())->where('domain', $_SERVER['HTTP_HOST'])->where('token', $post->token)->first();
            // if(!$user){
            //     return response()->json(['statuscode'=>'ERR','status'=>'ERR','message'=> 'Invalid Domain or Ip Address or Api Token']);
            // }
        }

        if (\Request::is('api/android/*')) {
           
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Dalvik') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Android') === false) {
                return ResponseHelper::failed("Unauthorize Access");
            }
            $checkHeader = \Request::header();
            //  dd($checkHeader) ;
            // dd();

            if (isset($checkHeader['apptoken']) && !empty($checkHeader['apptoken'][0])) {
                $token = $checkHeader['apptoken'][0];
                  $getApptoken = DB::table('securedatas')->where('apptoken', $token)->get();
                if ($getApptoken->count() >= 2) {
                    return ResponseHelper::failed('Your login in too many devices');
                } else if ($getApptoken->count() == 0) {
                    return ResponseHelper::unauthorized("Login session expired,Please login again");  //UNAUTHORIZED
                } else if ($getApptoken->count() == 1) {
                    $user_id = @$getApptoken[0]->user_id;
                    $user = User::where('id', $user_id)->first();

                    if ($user->status == "block") {
                        return ResponseHelper::failed("Account Blocked");
                    }

                    if ($user->company->status == "0") {
                        return ResponseHelper::failed("Service Down");
                    }
                    
                    if(isset($post->user_id) && $user->id != $post->user_id){
                           return ResponseHelper::unauthorized("Login session expired,Please login again");  //UNAUTHORIZED   
                    }
                }
                
                if(isset($post->user_id) && $user->id != $post->user_id){
                  return ResponseHelper::unauthorized("Login session expired,Please login again");  //UNAUTHORIZED   
                }

            } else {
                return ResponseHelper::unauthorized('Invalid Access/Login session expired,Please login again');
            }
        }

        return $next($post);
    }
}
