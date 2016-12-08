<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Session;
use Auth;
use Validator;
use MetzWeb\Instagram\Instagram;
use \Curl\Curl;

use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session as OAuthSession;
use OAuth\Common\Consumer\Credentials;

class LoginController extends Controller
{
    protected $socialite;
    protected $instagram;
    protected $url_api_login = 'https://auth.ten-po.com/v1/auth/login';
    protected $url_api_signup = 'https://api.ten-po.com/api/v2/signup';
    protected $url_api_signup_social = 'https://api.ten-po.com/api/v2/signup_social';
    protected $url_api_profile = 'https://api.ten-po.com/api/v2/profile';
    protected $url_api_profile_update = 'https://api.ten-po.com/api/v2/update_profile';
    protected $url_api_social_connect = 'https://api.ten-po.com/api/v2/social_profile';
    protected $url_api_social_cancel = 'https://api.ten-po.com/api/v2/social_profile_cancel';
    protected $url_api_push_setting = 'https://apinotification.ten-po.com/v1/user/set_push_setting';

    public function __construct(Socialite $socialite, Request $request){
        parent::__construct($request);
        $this->socialite = $socialite;
        
        $this->instagram = new Instagram(array(
            'apiKey'      => '17d7e27257b74d05b352fc55692b2b59',
            'apiSecret'   => 'e2cbde752038423f8f9c6100ef815634',
            'apiCallback' => route('instagram.connect')
        ));
    }
    
    public function login(){
        return view('login',[
            'app_info' => $this->app_info,
        ]);
    }
    
    public function loginNormal(){
        return view('login_normal');
    }
    
    public function loginNormalPost(Request $request){

        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
        );
        
        $message = array(
            'email.required' => '電子メールのフィールドは必須です。',
            'email.email' => 'メール誤タイプ',
            'password.required' => 'パスワードフィールドが必要です。',
            'password.min' => 'パスワードは少なくとも6文字でなければなりません。',
        );
        
        $v = Validator::make($request->all(), $rules, $message);
        if( $v->fails() ){
            return back()
                ->withInput()
                ->withErrors($v);
        }

        $curl = new Curl();
        $curl->setBasicAuthentication('tenposs','Tenposs@123');
        $curl = $curl->post($this->url_api_login,array(
            'email' => trim($request->input('email')) ,
            'password' => $request->input('password') ,
            'role' => 'user',
            'platform' => 'web'
        ));
        if ( $curl->code == 1000 && isset( $curl->data )){
            if( $curl->data->is_active != 1 )
            {
                Session::flash('message', array('class' => 'alert-danger', 'detail' => 'アカウントは有効ではありません') );
                return back()->withInput();
            }
            $token = $curl->data;
            // Get profile user
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.$token->token);
            $curl->get( $this->url_api_profile ,array(
                    'app_id' => $this->app->app_app_id
                ));
            if( $curl->response->code == 1000 ){
                $user = $curl->response->data->user;
                $data = (object)array_merge((array)$token, (array)$user);
                Session::put( 'user', $data );
            }else{
                Session::flash('message', array('class' => 'alert-danger', 'detail' => 'アクセス権がありません') );
                return back()->withInput();
            }
            return redirect('/');
        }

        Session::flash('message', array('class' => 'alert-danger', 'detail' => '間違ったメールアドレスまたはパスワード') );
        return back()->withInput();
        
    }
    
    public function logout(){
        Session::forget('user');
        return redirect('/');
    }
    
    public function register(){
        return view('signup_email');
    }
    
    public function registerPost(Request $request){
       
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password'
        );
        
        $message = array(
            'name.required' => '名前のフィールドが必要です。',
            'email.required' => '電子メールのフィールドは必須です。',
            'email.email' => 'メール誤タイプ',
            'password.required' => 'パスワードフィールドが必要です。',
            'password.min' => 'パスワードは少なくとも6文字でなければなりません。',
            'password_confirm.required' => 'パスワードの確認フィールドが必要です。',
            'password_confirm.min' => 'パスワードの確認は、少なくとも6文字でなければなりません。',
            'password_confirm.same' => 'パスワードの確認とパスワードが一致している必要があります。',
            
        );
        
        $v = Validator::make($request->all(), $rules,$message);
        if( $v->fails() ){
            return back()
                ->withInput()
                ->withErrors($v);
        }



        $curl = new Curl();
        $curl = $curl->post($this->url_api_signup, array(
            'email' => trim($request->input('email')) ,
            'password' => $request->input('password') ,
            'app_id' => $this->app->app_app_id,
            'name' => $request->input('name')
        ));

        if( $curl->code == 1000 ){
            Session::put('user', $curl->data);
            return redirect('/');
        }
        Session::flash('message', array('class'=>'alert-danger', 'detail'=>'再試行する') );
        return back()->withInput();
    }
    
    public function loginWithFacebook( Request $request ){

        $code = $request->get('code');
        $fb = \OAuth::consumer('Facebook');
        // if code is provided get user data and sign in
        if ( ! is_null($code))
        {
            // This was a callback request from facebook, get the token
            $social_token = $fb->requestAccessToken($code);

            $fb->getAccessToken();

            // Send a request with it
            $result = json_decode($fb->request('/me'), true);
            $curl = new Curl();
            $curl = $curl->post($this->url_api_signup_social, array(
                'app_id' => $this->app->app_app_id,
                'social_type' => 1 ,
                'social_id' => $result['id'],
                'social_token' => $social_token->getAccessToken() ,
                'social_secret' => config('oauth-5-laravel.consumers.Facebook.client_secret') ,
                'platform' => 'web'
            ));

            if( $curl->code == 1000 ){
                Session::put('user', $curl->data);
                return redirect('/');
            }
        }
        // if not ask for permission first
        else
        {
            // get fb authorization
            $url = $fb->getAuthorizationUri();
            // return to facebook login url
            return redirect((string)$url);
        }
    }

    public function loginWithTwitter( Request $request){
        $token  = $request->get('oauth_token');
        $verify = $request->get('oauth_verifier');
        $tw = \OAuth::consumer('Twitter');
        // if code is provided get user data and sign in
        if ( ! is_null($token) && ! is_null($verify))
        {
            $social_token = $tw->requestAccessToken($token, $verify);
            $result = json_decode($tw->request('account/verify_credentials.json'), true);
            $curl = new Curl();
            $curl = $curl->post($this->url_api_signup_social, array(
                'app_id' => $this->app->app_app_id,
                'social_type' => 2 ,
                'social_id' => $result['id'],
                'social_token' => $social_token->getAccessToken() ,
                'social_secret' => config('oauth-5-laravel.consumers.Twitter.client_secret') ,
                'platform' => 'web'
            ));
            if( $curl->code == 1000 ){
                Session::put('user', $curl->data);
                return redirect('/');
            }
        }
        else
        {
            // get request token
            $reqToken = $tw->requestRequestToken();
            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(['oauth_token' => $reqToken->getRequestToken()]);
            // return to twitter login url
            return redirect((string)$url);
        }
    }

    public function socialConnect(Request $request){
        $fb = \OAuth::consumer('Facebook', route('social.connect') );
        $tw = \OAuth::consumer('Twitter', route('social.connect') );
        
        $social_id = '';
        $social_token = '';
        $name = '';
        $social_type = '';
        
        //Facebook
        if( $request->has('code') ){
            $code = $request->get('code');
            if ( ! is_null($code))
            {
                $token = $fb->requestAccessToken($code);
                $result = json_decode($fb->request('/me'), true);
                $social_id = $result['id'];
                $social_token = $token->getAccessToken();
                $social_secret = config('oauth-5-laravel.consumers.Facebook.client_secret');
                $name = $result['name'];
                $social_type = 1;
                
                
            }else{
                abort(404);
            }
            
        }
        //Twitter
        if( $request->has('oauth_token') &&  $request->has('oauth_verifier') ){
            $token  = $request->get('oauth_token');
            $verify = $request->get('oauth_verifier');
            // if code is provided get user data and sign in
            if ( ! is_null($token) && ! is_null($verify))
            {
                // This was a callback request from twitter, get the token
                $token = $tw->requestAccessToken($token, $verify);
                // Send a request with it
                $result = json_decode($tw->request('account/verify_credentials.json'), true);
                $social_id = $result['id'];
                $social_token = $token->getAccessToken();
                $social_secret = config('oauth-5-laravel.consumers.Twitter.client_secret');
                $name = $result['name'];
                $social_type = 2;
            }else{
                abort(404);
            }
        }
        // Update connect social
        $curl = new Curl();
        $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
        $curl = $curl->post($this->url_api_social_connect, array(
            'app_id' => $this->app->app_app_id,
            'social_type' => $social_type ,
            'social_id' => $social_id,
            'social_token' => $social_token ,
            'social_secret' => $social_secret ,
            'nickname' => $name
        ));
        if( $curl->code == 1000 ){
            Session::flash('message', array('class' => 'alert alert-success', 'detail' => '社会的成功をつなぐ' ) );
        }else{
            Session::flash('message',  array('class' => 'alert alert-success', 'detail' => 'ソーシャルフェイルを接続する' ));
        }
        return redirect()->route('profile');
    }
    
    public function socialCancelConnect(Request $request, $type){
        
        if( in_array( $type, [1,2,3] ) ){
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl = $curl->post($this->url_api_social_cancel, array(
                'app_id' => $this->app->app_app_id,
                'social_type' => $type ,
            ));
            if( $curl->code == 1000 ){
                Session::flash('message', array('class' => 'alert-success', 'detail' => 'プロファイルをキャンセルする!' ) );
                return redirect()->route('profile');
            }
        }
        Session::flash('message', array('class' => 'alert-success', 'detail' => 'プロファイルのキャンセルをキャンセルする!' ) );
        return redirect()->route('profile');
    }
    
    public function profile(Request $request){
        
        $fb = \OAuth::consumer('Facebook', route('social.connect') );
        $tw = \OAuth::consumer('Twitter', route('social.connect') );
    
        $url_fb = $fb->getAuthorizationUri();
        // get request token
        $reqTokenTw = $tw->requestRequestToken();
        // get Authorization Uri sending the request token
        $url_tw = $tw->getAuthorizationUri(['oauth_token' => $reqTokenTw->getRequestToken()]);

        return view('profile',
        [
            'fb_url' => (string)$url_fb,
            'tw_url' => (string)$url_tw,
            'instagram_login_url' => $this->instagram->getLoginUrl(),
            'user' => Session::get('user'),
            'app_info' => $this->app_info
        ]);
    }
    
    public function profilePost( Request $request ){
      
        // save avatar
        $rules = array(
            'name' => 'required',
            'address' => 'required'
        );
        
        $messages = array(
            'name.required' => '名前のフィールドが必要です。',
            'address.required' => 'アドレスがnullではないことができます'
        );
        
        $v = Validator::make($request->all(), $rules,$messages);
        if( $v->fails() ){
            return back()
                ->withInput()
                ->withErrors($v);
        }
        
        
        if( $request->hasFile('avatar') ){
            $file = $request->file('avatar');
            if( $file ) {
                
                $destinationPath = public_path('uploads/avatar');
                $extension = $file->getClientOriginalExtension();
                $fileName = md5($file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension;
                $file->move($destinationPath, $fileName);
                $url = 'uploads/avatar/' . $fileName;
                if (function_exists('curl_file_create')) { // php 5.6+
                    $cFile = curl_file_create( public_path($url) );
                } else { // 
                    $cFile = '@' . public_path($url) ;
                }
                $params = [
                    'app_id' => $this->app->app_app_id,
                    'username' => $request->input('name') ,
                    'gender' => $request->input('gender'),
                    'address' => $request->input('address'),
                    'avatar' => $cFile
                ];
            }
            
        }else{
            $params = [
                'app_id' => $this->app->app_app_id,
                'username' => $request->input('name') ,
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'avatar' => ''
            ];
        }

        $curl = new Curl();
        $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
        $curl = $curl->post($this->url_api_profile_update, $params);

        if( $curl->code == 1000 ){
            Session::flash('message', \App\Utils\Messages::customMessage( 2002, 'alert-success' ));
            // update session profile
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl->get( $this->url_api_profile ,array(
                'app_id' => $this->app->app_app_id
            ));

            if( $curl->response->code == 1000 ){
                $currentUser = Session::get('user');
                $updateProfile = $data = (object)array_merge((array)$currentUser, (array)$curl->response->data->user);
                Session::put('user',$updateProfile );
            }

            return back();
        }
        Session::flash('message', \App\Utils\Messages::customMessage( 2001, 'alert-danger' ));
        return back();
        
    }
    
    public function instagramConnect(Request $request){
        // grab OAuth callback code
        $code = $request->input('code');
        $data = $this->instagram->getOAuthToken($code);
        if( $data ){

            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl = $curl->post($this->url_api_social_connect, array(
                'app_id' => $this->app->app_app_id,
                'social_type' => 3 ,
                'social_id' => $data->user->id,
                'social_token' => $data->access_token ,
                'social_secret' => config('oauth-5-laravel.consumers.Instagram.client_secret') ,
                'nickname' => $data->user->full_name
            ));
            if( $curl->code == 1000 ){
                Session::flash('message', array('class' => 'alert alert-success', 'detail' => '社会的成功をつなぐ' ) );
            }else{
                Session::flash('message',  array('class' => 'alert alert-success', 'detail' => 'ソーシャルフェイルを接続する' ));
            }

            return redirect()->route('profile');
        }
    }

    public function setPushKey(Request $request){
        // set push key after login
        if( $request->ajax() && $request->has('key') ){

            $postPushKey = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('set_push_key',[
                        'token' => Session::get('user')->token,
                        'client' =>  3,
                        'key' => $request->input('key')
                    ],
                    $this->app->app_app_secret);
            $responsePushKey = json_decode($postPushKey);

            if( $responsePushKey->code == 1000 ){
                Session::put('setpushkey', true );
                return response()->json(['msg' => 'Set push key success' ]);
            }
        }

    }

}
