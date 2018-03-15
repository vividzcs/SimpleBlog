<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!empty(session('user'))){
            $username = session('user')->username;
            $password = session('user')->password;
            //dd($password);
            $user = DB::table('user')->where('username',$username)->where('password',$password)->first();
            //dd($user);
            if(empty($user)){
                return redirect('admin/login');
            }
        }else{
            return redirect('admin/login');
        }
        
        
        return $next($request);
    }
}
