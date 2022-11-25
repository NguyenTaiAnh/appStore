<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\AdminAuth as Middleware;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        if (now()->diffInMinutes(session('lastActivityTime')) >= (60) ) {  // also you can this value in your config file and use here
//            if (auth()->check()) {
//                if(!auth()->user()->is_admin){
//                    return redirect()->route('getLogin')->with('error','You have to be admin user to access this page');
//                }
//                auth()->logout();
//
////                $this->reCacheAllUsersData();
//
//                session()->forget('lastActivityTime');
//
//                return redirect(route('getLogin'));
//            }
//
//        }
//        session(['lastActivityTime' => now()]);
//
//        return $next($request);
        if(auth()->check()){
            if(!auth()->user()->is_admin){
                return redirect()->route('getLogin')->with('error','You have to be admin user to access this page');
            }
        }else{
            return redirect()->route('getLogin')->with('error','You have to be logged in to access this page');
        }
        return $next($request);
    }
}
