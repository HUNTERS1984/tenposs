<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use JWTAuth;
use \Curl\Curl;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $api_refresh_token = 'https://auth.ten-po.com/v1/auth/access_token';

    public function handle($request, Closure $next)
    {
        if( !Session::has('user') ){
            return redirect()->route('login');
        }
        $currentSessionUser = Session::get('user');
        try{
            JWTAuth::setToken( $currentSessionUser->token );
            $token = JWTAuth::getToken();
            $user = JWTAuth::getPayload( $token );

        } catch (TokenExpiredException $e) {

            $curl = new Curl();
            $curl->setBasicAuthentication('tenposs','Tenposs@123');
            $params = array(
                'id_code' => $currentSessionUser->refresh_token,
                'refresh_token' => $currentSessionUser->access_refresh_token_href
            );

            $curl = $curl->post($this->api_refresh_token,$params);
            dd($curl);
            if ( isset($curl->code) && $curl->code == 1000 && isset( $curl->data )){
                unset($currentSessionUser->token);
                unset($currentSessionUser->refresh_token);
                unset($currentSessionUser->access_refresh_token_href);
                $updateToken = (object)array_merge((array)$currentSessionUser, (array)$curl->data);
                Session::put('user',$updateToken );
            }else{
                Session::forget('user');
                return redirect()->route('login')->withErrors('Session expired');
            }

        } catch (JWTException $e) {
            Session::forget('user');
            return redirect()->route('login')->withErrors('Session expired');
        } catch (TokenBlacklistedException $e) {
            Session::forget('user');
            return redirect()->route('login')->withErrors('Session expired');
        }
        return $next($request);
    }
}
