<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Session;
use Auth;
use Validator;
use MetzWeb\Instagram\Instagram;

use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session as OAuthSession;
use OAuth\Common\Consumer\Credentials;

class LoginController extends Controller
{
    protected $socialite;
    protected $instagram;
    
    
    public function __construct(Socialite $socialite, Request $request){
        parent::__construct($request);
        $this->socialite = $socialite;
        
        $this->instagram = new Instagram(array(
            'apiKey'      => '17d7e27257b74d05b352fc55692b2b59',
            'apiSecret'   => 'e2cbde752038423f8f9c6100ef815634',
            'apiCallback' => route('instagram.callback')
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
        $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('signin',[
                     'app_id' => $this->app->app_app_id,
                     'email' =>  $request->input('email') ,
                     'password' => $request->input('password') ,
                ],
                $this->app->app_app_secret); 
                
        $response = json_decode($post);

        if( \App\Utils\Messages::validateErrors($response) ){
            Session::put('user', $response->data);
            return redirect('/');
        }
        Session::flash('message', \App\Utils\Messages::customMessage('2003') );
        return back()->withInput();
        
    }
    
    public function logout(){
        Session::forget('user');
        return redirect('/login');
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
        
        
        $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('signup',[
                     'app_id' => $this->app->app_app_id,
                     'email' =>  $request->input('email') ,
                     'name' => $request->input('name') ,
                     'password' => $request->input('password') ,
                ],
                $this->app->app_app_secret); 
                
        $response = json_decode($post);
        
        if( \App\Utils\Messages::validateErrors($response) ){
            Session::put('user', $response->data);
            return redirect('/');
        }else{
            Session::flash('message', \App\Utils\Messages::getMessage( $response ));
            return back()->withInput();
        }

    }
    
    public function getSocialAuth( $provider = null ){
        if(!config("services.$provider")) 
            abort('404');
        return $this->socialite->with($provider)->redirect();
    }
    
    
    public function getSocialAuthCallback( $provider = null){

        if($user = $this->socialite->with($provider)->user()){
            
            if( $provider == 'facebook' ){
                $params = [
                    'app_id' => $this->app->app_app_id,
                    'social_type' => 1,
                    'social_id' => $user->id ,
                    'social_token' => $user->token ,
                    'social_secret' => '',
                    'name' => $user->name,
                    
                ];
            }
            
            if( $provider == 'twitter' ){
            
                $params = [
                    'app_id' => $this->app->app_app_id,
                    'social_type' => 2,
                    'social_id' => $user->id ,
                    'social_token' => $user->token ,
                    'social_secret' => $user->tokenSecret,
                    'name' => $user->name,
                    
                ];
            }
        
            
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('social_login',$params,
                $this->app->app_app_secret);  
                
            $response = json_decode($post);
          
            if( \App\Utils\Messages::validateErrors($response) ){
                Session::put('user', $response->data);
                return redirect('/');
            }
            Session::flash('message', \App\Utils\Messages::getMessage( $response ));
            return back();
           
        }else{
            Session::flash('message', \App\Utils\Messages::customMessage(2000) );
            return back();
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
    
    public function getSocialConnectCallback(Request $request){
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
                $name = $result['name'];
                $social_type = 2;
            }else{
                abort(404);
            }
        }
        // Update connect social
        if( $social_id != '' && $social_token != '' ){
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('social_profile',[
                    'token' => Session::get('user')->token,
                    'social_type' => $social_type,
                    'social_id' => $social_id,
                    'social_token' => $social_token,
                    'nickname' => $name
                ],
                $this->app->app_app_secret);    
            
            $response = json_decode($post);
           
            if( ! \App\Utils\Messages::validateErrors($response) ){
                Session::flash('message', \App\Utils\Messages::customMessage( 2001 ));
                return back();
            }
            
            return redirect()->route('profile');
        }
        
        Session::flash('message', \App\Utils\Messages::customMessage( 2004 ));
        return redirect()->route('profile');
    }
    
    public function socialCancelConnect(Request $request, $type){
        
        if( in_array( $type, [1,2,3] ) ){
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('social_profile_cancel',[
                    'token' => Session::get('user')->token,
                    'social_type' => $type
                ],
            $this->app->app_app_secret);    
            $response = json_decode($post);
            if( $response->code == 1000 ){
                Session::flash('message', \App\Utils\Messages::customMessage( 2005, 'alert-success' ));
                return redirect()->route('profile');
            }
        }
        Session::flash('message', \App\Utils\Messages::customMessage( 2006 ));
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
 
        
        $get = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('profile',[
                'token' => Session::get('user')->token
            ],
            $this->app->app_app_secret);    
        
        $response = json_decode($get);
        //dd($response);
        if( \App\Utils\Messages::validateErrors($response) ){
            return view('profile', 
            [ 
                'fb_url' => (string)$url_fb,
                'tw_url' => (string)$url_tw,
                'instagram_login_url' => $this->instagram->getLoginUrl(),
                'profile' => $response,
                'app_info' => $this->app_info
            ]);
        }else{
            Session::flash('message', \App\Utils\Messages::customMessage( 2001 ));
            return back();
        }

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
                
                $destinationPath = public_path('uploads'); // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = md5($file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
                $file->move($destinationPath, $fileName); // uploading file to given path
                $url = 'uploads/' . $fileName;
                if (function_exists('curl_file_create')) { // php 5.6+
                    $cFile = curl_file_create( public_path($url) );
                } else { // 
                    $cFile = '@' . public_path($url) ;
                }
                $params = [
                    'token' => Session::get('user')->token,
                    'username' => $request->input('name') ,
                    'gender' => $request->input('gender'),
                    'address' => $request->input('address'),
                    'avatar' => $cFile
                ];
                $post = \App\Utils\HttpRequestUtil::getInstance()
                    ->post_data_file('update_profile',$params,$this->app->app_app_secret);
                
            }
            
        }else{
            $params = [
                'token' => Session::get('user')->token,
                'username' => $request->input('name') ,
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'avatar' => ''
            ];
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('update_profile',$params,$this->app->app_app_secret);
        }
       
        $response = json_decode($post);
     
        if( $response->code == 1000 ){
            Session::flash('message', \App\Utils\Messages::customMessage( 2002, 'alert-success' ));
            return back();
        }
        Session::flash('message', \App\Utils\Messages::customMessage( 2001, 'alert-danger' ));
        return back();
        
    }
    
    public function instagramAuthCallback(Request $request){
        // grab OAuth callback code
        $code = $request->input('code');
        $data = $this->instagram->getOAuthToken($code);
        if( $data ){
            $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('social_profile',[
                    'token' => Session::get('user')->token,
                    'social_type' => 3,
                    'social_id' => $data->user->id,
                    'social_token' => $data->access_token,
                    'nickname' => $data->user->full_name
                ],
                $this->app->app_app_secret);    
            
            $response = json_decode($post);
            
            if( \App\Utils\Messages::validateErrors($response) ){
                return redirect()->route('profile');
            }else{
                Session::flash('message', \App\Utils\Messages::customMessage( 2001 ));
                return back();
            }
        
        }

    }
}
