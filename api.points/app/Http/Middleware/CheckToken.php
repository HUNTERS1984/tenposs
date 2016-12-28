<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\TokenMismatchException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class CheckToken extends BaseMiddleware
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
        }
        catch (TokenMismatchException $e) {
            return new JsonResponse(['code' => 10013,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
        catch (JWTException $e) {
            return new JsonResponse(['code' => 10012,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
        return $next($request);
    }
}
