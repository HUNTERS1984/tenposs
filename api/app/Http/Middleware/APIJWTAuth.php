<?php

namespace App\Http\Middleware;

use Closure;

use Session;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;
use Illuminate\Http\JsonResponse;

class APIJWTAuth extends BaseMiddleware
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


        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }
        try {
            JWTAuth::parseToken()->getPayload();
        } catch (TokenExpiredException $e) {
            return new JsonResponse(['code' => 10011,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return new JsonResponse(['code' => 10010,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (JWTException $e) {
            return new JsonResponse(['code' => 10012,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
        return $next($request);
    }
}
