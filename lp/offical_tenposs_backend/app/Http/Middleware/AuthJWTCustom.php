<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;
use App\Models\App;
use App\Models\Store;
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
        //$request->headers->set('Authorization', 'Bearer '.Session::get('jwt_token'));
        //$token = $this->auth->setRequest($request)->getToken();
        
        // Way 2
        
        if( !Session::has('jwt_token') )
            return redirect()->route('login')->withErrors('Please login');
            
        JWTAuth::setToken(Session::get('jwt_token'));
        $token = JWTAuth::getToken();

        try {
            
            $user = $this->auth->getPayload( $token );
            Session::put('user', $user);
            $request->user = $user->get();
            if ($request->user) {
 
                $request->app = App::whereUserId($request->user['sub'])->first();
                
                if ($request->app) {
                    $request->stores =  Store::whereAppId($request->app->id)->get();
                }
                
            }
        } catch (TokenExpiredException $e) {
            
            $newToken = JWTAuth::refresh($token);
            Session::put('jwt_token', $newToken);
            return $next($request);
            
        } catch (JWTException $e) {
            
            return redirect()->route('login')->withErrors('Token Signature could not be verified.');
            //return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        $this->events->fire('tymon.jwt.valid', $user);
        return $next($request);
    
    }
}
