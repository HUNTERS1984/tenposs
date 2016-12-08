<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;
use App\Models\App;
use App\Models\UserInfos;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;
use cURL;
use Config;

class AuthJWTCustom extends BaseMiddleware

{

    protected $api_user_profile = 'https://auth.ten-po.com/v1/profile';
    protected $api_refresh_token = 'https://auth.ten-po.com/v1/auth/access_token';

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

        JWTAuth::setToken(Session::get('jwt_token')->token);
        $token = JWTAuth::getToken();
        
        try {
            // call api to get user profile
            if ( Session::get('user') == null ) {
                $requestProfile = cURL::newRequest('get', $this->api_user_profile )
                    ->setHeader('Authorization',  'Bearer '. $token );

                $responseProfile = $requestProfile->send();
                $profile = json_decode($responseProfile->body);
                
                if( isset($profile->code) && $profile->code == 1000 ){
                    $user_info = UserInfos::find($profile->data->id );
                    $profile->data->user_info = $user_info;
                    Session::put('user', $profile->data );
                } else {
                    // refresh token
                    $requestRefresh = cURL::newRequest('post', $this->api_refresh_token,[
                        'id_code' => Session::get('jwt_token')->refresh_token,
                        'refresh_token' => Session::get('jwt_token')->access_refresh_token_href
                    ] )->setHeader('Authorization',  'Bearer '. $token );

                    $responseRefresh = $requestRefresh->send();
                    $responseRefresh = json_decode($responseRefresh->body);
                    if( isset($responseRefresh->code) && $responseRefresh->code == 1000 ){
                        Session::put('jwt_token', $responseRefresh->data);
                    }else{
                        return redirect()->route('login')->withErrors('Session expired');
                    }

                }
            }

            $user = $this->auth->getPayload( $token );
            $request->user = $user->get();
            if ($request->user) {
                $request->app = App::whereUserId( $request->user['id'] )->first();
                if ($request->app) {
                    $request->stores =  Store::whereAppId($request->app->id)->get();
                }
            }
        } catch (TokenExpiredException $e) {
            
            Session::put('jwt_token', null);
            Session::put('user', null);
            return redirect()->route('login')->withErrors('Session expired');
            
        } catch (JWTException $e) {
            return redirect()->route('login')->withErrors('Token Signature could not be verified.');
            //return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        } catch (TokenBlacklistedException $e) {
            
            Session::put('jwt_token', null);
            Session::put('user', null);
            return redirect()->route('login')->withErrors('Session expired');
        }
        
        $this->events->fire('tymon.jwt.valid', $user);
        return $next($request);
    
    }
}
