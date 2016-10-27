<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;
class AuthJWTCustom extends BaseMiddleware
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
       
        // Way 1
        $request->headers->set('Authorization', 'Bearer '.Session::get('jwt_token'));
        $token = $this->auth->setRequest($request)->getToken();
        
        // Way 2
        JWTAuth::setToken(Session::get('jwt_token'));
        $token = JWTAuth::getToken();
       
        if (! $token  ) {
            return redirect()->route('login')->withErrors('Please login');
        }

        try {
            $user = $this->auth->getPayload( $token );
            $request->user = $user->get();
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    
    }
}
