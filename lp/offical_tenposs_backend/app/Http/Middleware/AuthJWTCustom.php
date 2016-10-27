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
       
        $request->headers->set('Authorization', 'Bearer '.Session::get('jwt_token'));
        $token = $this->auth->setRequest($request)->getToken();
        
        if (! $token  ) {
            return redirect()->route('login')->withErrors('Please login');
        }
        dd($this->auth->authenticate($token));
        //dd( $this->auth->getPayload( $token ) );
        JWTAuth::setToken(Session::get('jwt_token'));
        //dd(JWTAuth::getToken());
        dd(JWTAuth::parseToken()->authenticate());
        
        
        dd( $this->auth->parseToken()->authenticate()) ;
        
        

        dd($this->auth->parseToken()->authenticate());
        //
        try {
            
            $user = $this->auth->authenticate($token);
            
            
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (! $user) {
            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    
    }
}
