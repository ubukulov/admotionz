<?php

namespace App\Http\Middleware;

use App\User;
use Closure;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!User::hasRole($role)){
            return redirect()->back();
        }

        return $next($request);
    }
}
