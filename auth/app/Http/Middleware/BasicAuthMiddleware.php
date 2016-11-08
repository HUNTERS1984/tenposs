<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getUser() != 'tenposs' || $request->getPassword() != 'Tenposs@123') {
            $headers = array('WWW-Authenticate' => 'Basic');
            return response(array('code' => 99955, 'message' => 'Auth invalid.'), Response::HTTP_UNAUTHORIZED,$headers);

        }
        return $next($request);
    }
}