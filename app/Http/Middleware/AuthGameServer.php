<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthGameServer
{
    public function handle(Request $request, Closure $next)
    {
        if (!is_null(config('services.game_server')) && $request->bearerToken() != config('services.game_server.token')) {
            abort(401);
        }


        if(config('app.env') == 'production' && $request->ip() != config('services.game_server.ip')) {
            abort(401);
        }

        return $next($request);
    }
}
