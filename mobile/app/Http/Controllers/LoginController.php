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
use Artdarek\OAuth\Facade\OAuth;

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
    protected $url_api_signout = 'https://auth.ten-po.com/v1/auth/signout';

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
        return view('users.login',[
            'app_info' => $this->app_info,
        ]);
    }
    
    public function loginNormal(){
        return view('users.login_email',[
            'app_info' => $this->app_info,
        ]);
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

        if ( isset($curl->code) && $curl->code == 1000 && isset( $curl->data )){
            if( $curl->data->is_active != 1 )
            {
                return back()->withErrors('アカウントは有効ではありません');
            }
            $token = $curl->data;
            // Get profile user
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.$token->token);
            $curl->get( $this->url_api_profile ,array(
                    'app_id' => $this->app->app_app_id
                ));

            if( isset($curl->response->code) && $curl->response->code == 1000 ){
                $user = $curl->response->data->user;
                $data = (object)array_merge((array)$token, (array)$user);
                Session::put( 'user', $data );
            }else{
                return back()
                    ->withErrors('アカウントは有効ではありません')
                    ->withInput();
            }
            return redirect('/');
        }

        return back()
            ->withErrors('間違ったメールアドレスまたはパスワード')
            ->withInput();
        
    }
    
    public function logout(){
        Session::forget('user');
        Session::forget('app');
        return redirect('/');
    }
    
    

    public function registerStep2(){

        if( !Session::has('registerStep1') && !Session::has('user') ){
            return redirect()->route('login');
        }
        return view('users.signup_email_step2',[
            'app_info' => $this->app_info,
        ]);
    }

    public function registerStep2Post(Request $request){

        if( !Session::has('registerStep1') && !Session::has('user'))
            return redirect()->route('login');

        if( Session::has('registerStep1') ){
            $curl = new Curl();
            $curl = $curl->post($this->url_api_signup, array(
                'email' => trim( Session::get('registerStep1')['email'] ) ,
                'password' => Session::get('registerStep1')['password'] ,
                'app_id' => $this->app->app_app_id,
                'name' => Session::get('registerStep1')['name']
            ));

           
            if( isset($curl->code) && $curl->code == 1000 ){
                Session::put('user', $curl->data);
            }
            elseif( isset($curl->code) && $curl->code == 9996 ){
                return back()
                    ->withErrors('ユーザーは存在します')
                    ->withInput();
            }
            else{
                return back()
                    ->withErrors('エラー')
                    ->withInput();
            }

        }
        
        // Update profile
        $curl = new Curl();
        $curl->setHeader('Authorization','Bearer '. Session::get('user')->token);
        $curl = $curl->post( 'https://api.ten-po.com/api/v2/update_profile_social_signup', array(
            'app_id' => $this->app->app_app_id ,
            'birthday' => ( $request->has('birthday') ) ? date('Y-d-d',strtotime($request->input('birthday'))) : '' ,
            'address' => $request->input('address') ,
            'code' => $request->input('code'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender')
        ));

        if( isset($curl->code) && $curl->code == 1000 ){
            return redirect('/');
        }
        return back()
            ->withErrors('登録できませんでした')
            ->withInput();

    }

    public function register(){
        if( Session::has('registerStep1') )
            return redirect()->route('register.step2');

        return view('users.signup_email',[
            'app_info' => $this->app_info,
        ]);
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
            'email.required' => 'メールのフィールドは必須です。',
            'email.email' => 'メールが違います。',
            'password.required' => 'パスワードフィールドが必要です。',
            'password.min' => 'パスワードは6文字以上でなければなりません。',
            'password_confirm.required' => 'パスワードの確認フィールドが必要です。',
            'password_confirm.min' => 'パスワードは6文字以上でなければなりません。',
            'password_confirm.same' => 'パスワードは一致しなければなりません。',
            
        );
        
        $v = Validator::make($request->all(), $rules,$message);
        if( $v->fails() ){
            return back()
                ->withInput()
                ->withErrors($v);
        }

        Session::put('registerStep1', $request->all());
        return redirect()->route('register.step2');
    }
    
    public function loginWithFacebook( Request $request ){

        $code = $request->get('code');
        $fb = OAuth::consumer('Facebook');
        // if code is provided get user data and sign in
        if ( ! is_null($code))
        {
            // This was a callback request from facebook, get the token
            $social_token = $fb->requestAccessToken($code);
            // Send a request with it
            $result = json_decode($fb->request('/me'), true);
            $curl = new Curl();
            $params = array(
                'app_id' => $this->app->app_app_id,
                'social_type' => 1 ,
                'social_id' => $result['id'],
                'social_token' => $social_token->getAccessToken() ,
                'social_secret' => config('oauth-5-laravel.consumers.Facebook.client_secret') ,
                'platform' => 'web',
                'avartar_url' => "//graph.facebook.com/".$result['id']."/picture?type=large",
                'username' => $result['name']
            );
            $curl = $curl->post($this->url_api_signup_social, $params);

            if( isset($curl->code) && $curl->code == 1000 ){
                Session::put('user', $curl->data);
                if( $curl->data->first_login )
                    return redirect()->route('register.step2');
                return redirect('/');
            }

            return back()->withErrors('社会的にサインアップできない');

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
        $tw = OAuth::consumer('Twitter');
        // if code is provided get user data and sign in
        if ( ! is_null($token) && ! is_null($verify))
        {
            $social_token = $tw->requestAccessToken($token, $verify);
            $result = json_decode($tw->request('account/verify_credentials.json'), true);
            $curl = new Curl();
            $params = array(
                'app_id' => $this->app->app_app_id,
                'social_type' => 2 ,
                'social_id' => $result['id'],
                'social_token' => $social_token->getAccessToken() ,
                'social_secret' => $social_token->getAccessTokenSecret(),
                'platform' => 'web',
                'avartar_url' => (isset($result['profile_image_url'])) ? str_replace('_normal','',$result['profile_image_url']) : '',
                'username' => (isset($result['name'])) ? $result['name'] : ''
            );
            $curl = $curl->post($this->url_api_signup_social,$params );
            if( isset($curl->code) && isset( $curl->code ) && $curl->code == 1000 ){
                Session::put('user', $curl->data);
                if( $curl->data->first_login )
                    return redirect()->route('register.step2');
                return redirect('/');
            }


            return back()->withErrors('社会的にサインアップできない');
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
        $fb = OAuth::consumer('Facebook', route('social.connect') );
        $tw = OAuth::consumer('Twitter', route('social.connect') );
        
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
                $social_secret = $token->getAccessTokenSecret();
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
        if( isset($curl->code) && $curl->code == 1000 ){
            $msg = '社会的成功をつなぐ';
        }else{
            $msg ='ソーシャルフェイルを接続する';
        }
        return back()
            ->withErrors($msg);
    }
    
    public function socialCancelConnect(Request $request, $type){
        
        if( in_array( $type, [1,2,3] ) ){
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl = $curl->post($this->url_api_social_cancel, array(
                'app_id' => $this->app->app_app_id,
                'social_type' => $type ,
            ));
            if( isset($curl->code) && $curl->code == 1000 ){
                return back()->withErrors('プロファイルをキャンセルする!');

            }
        }

        return back()->withErrors('プロファイルのキャンセルをキャンセルする!' );

    }
    
    public function profile(Request $request){
        
        $fb = OAuth::consumer('Facebook', route('social.connect') );
        $tw = OAuth::consumer('Twitter', route('social.connect') );
    
        $url_fb = $fb->getAuthorizationUri();
        // get request token
        $reqTokenTw = $tw->requestRequestToken();
        // get Authorization Uri sending the request token
        $url_tw = $tw->getAuthorizationUri(['oauth_token' => $reqTokenTw->getRequestToken()]);
        // get profile
        // update session profile
        $curl = new Curl();
        $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
        $curl->get( $this->url_api_profile ,array(
            'app_id' => $this->app->app_app_id
        ));

        if( isset($curl->response->code) && $curl->response->code == 1000 ){
            $currentUser = Session::get('user');
            unset($currentUser->profile);
            $updateProfile = $data = (object)array_merge((array)$currentUser, (array)$curl->response->data->user);
            Session::put('user',$updateProfile );
            //dd($updateProfile->profile->avatar_url);

            if (!@getimagesize($updateProfile->profile->avatar_url)) {
                $updateProfile->profile->avatar_url = null;
            } 
            return view('users.profile',
                [
                    'fb_url' => (string)$url_fb,
                    'tw_url' => (string)$url_tw,
                    'instagram_login_url' => $this->instagram->getLoginUrl(),
                    'user' => Session::get('user'),
                    'app_info' => $this->app_info,
                    'is_social' => strpos($updateProfile->email, 'fb.com') || strpos($updateProfile->email, 'tw.com'),
                ]);
        }

        return back()->withErrors('再試行する');

    }
    
    public function profilePost( Request $request ){
      
        // save avatar
        $rules = array(
            'name' => 'required',
            'address' => 'required'
        );
        
        $messages = array(
            'name.required' => '名前のフィールドが必要です。',
            'address.required' => 'アドレスがが必要です。'
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

        if( isset($curl->code) && $curl->code == 1000 ){
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl->get( $this->url_api_profile ,array(
                'app_id' => $this->app->app_app_id
            ));

            if( isset($curl->response->code) && $curl->response->code == 1000 ){
                $currentUser = Session::get('user');
                unset($currentUser->profile);
                $updateProfile = $data = (object)array_merge((array)$currentUser, (array)$curl->response->data->user);
                Session::put('user',$updateProfile );
            }

            return back()->withErrors('プロファイルを編集しました');
        }
        return back()->withErrors('プロファイルを編集できませんでした');
        
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
            if( isset($curl->code) && $curl->code == 1000 ){
                $msg = '社会的成功をつなぐ' ;
            }else{
                $msg ='ソーシャルフェイルを接続する';
            }
            return back()
                ->withErrors($msg);
        }
    }

    public function setPushKey(Request $request){
        // set push key after login
        if( $request->ajax() && $request->has('key') ){
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl = $curl->post('https://apinotification.ten-po.com/v1/user/set_push_key',array(
                'key' => $request->input('key'),
                'client' => 'web',
                'app_id' => $this->app->app_app_id
            ));

            if( isset($curl->code) && $curl->code == 1000 ){
                Session::put('setpushkey', true );
                return response()->json(['msg' => 'Set push key success' ]);
            }

            return response()->json(['msg' => 'Set push key fail' ]);
        }
    }

}
