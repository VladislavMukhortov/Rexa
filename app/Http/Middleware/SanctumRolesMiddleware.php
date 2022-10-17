<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanctumRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if (auth('sanctum')->user()->tokenCan("role:$role")) {

                return $next($request);
            }
        }
        return route('login');
    }
}
