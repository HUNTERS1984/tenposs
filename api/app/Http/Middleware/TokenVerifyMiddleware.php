<?php

namespace App\Http\Middleware;

use Closure;

class TokenVerifyMiddleware
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
        if( !$request->has('_token') ){
            return response()->json(['No token'],403);
        }
        return $next($request);
    }
}
