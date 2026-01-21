<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ApiLogActivity
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($post, Closure $next)
    {
        if (\Request::is('api/android/*')) {
            $field['ipaddress'] = $post->ip();
            // $field['json_request'] = json_encode($post->all());
            $_SERVER['REQUEST_URI'] == "/api/android/user/login" ? $field['json_request'] = null : $field['json_request'] = json_encode($post->all());
            $_SERVER['REQUEST_URI'] == "/api/android/user/login" ? $field['user_id'] = $post->mobile : $field['user_id'] = @$post->user_id ?? @$post->userId;

            $field['url'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $field['header'] = json_encode(\Request::header());
            $field['type'] = @$_SERVER['REQUEST_URI'];

            // $field['json_request'] = json_encode(\Request::all());
            DB::table('android_logs')->insert($field);

        }
        return $next($post);
    }
}
