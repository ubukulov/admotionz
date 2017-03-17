<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

//        # Рекламодатель
//        if(Auth::guard($guard)->attempt(['login' => $request->input('login'), 'password' => $request->input('password'), 'role' => 3, 'block' => 0])){
//            return redirect()->intended('advertiser');
//        }
//        # Испольнитель
//        if(Auth::guard($guard)->attempt(['login' => $request->input('login'), 'password' => $request->input('password'), 'role' => 4, 'block' => 0])){
//            return redirect()->intended('user');
//        }
//        # Суперадминистратор
//        if(Auth::guard($guard)->attempt(['login' => $request->input('login'), 'password' => $request->input('password'), 'role' => 1, 'block' => 0])){
//            return redirect()->intended('admin');
//        }
//        # Модератор
//        if(Auth::guard($guard)->attempt(['login' => $request->input('login'), 'password' => $request->input('password'), 'role' => 2, 'block' => 0])){
//            return redirect()->intended('moderator');
//        }

        return $next($request);
    }
}
