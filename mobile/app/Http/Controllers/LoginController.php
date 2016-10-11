<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Session;
use Auth;
use Validator;
use MetzWeb\Instagram\Instagram;


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
        
        $v = Validator::make($request->all(), $rules);
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
        Session::flash('message', \App\Utils\Messages::getMessage( $response ));
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
            'name' => 'required|alpha_num',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password'
        );
        
        $v = Validator::make($request->all(), $rules);
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
                if( \App\Utils\Messages::validateErrors($responsePushKey) ){
                    return response()->json(['msg' => 'Set push key success' ]);
                }
        }
        
    }
    
    public function profile(){
    
        $get = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('profile',[
                'token' => Session::get('user')->token
            ],
            $this->app->app_app_secret);    
        
        $response = json_decode($get);
        
        if( \App\Utils\Messages::validateErrors($response) ){
            return view('profile', 
            [ 
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
        
        if( $request->hasFile('avatar') ){
            
            
            $file = $request->file('avatar');
          
            if( $file ) {
                
                $destinationPath = public_path('uploads'); // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = md5($file->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
                $file->move($destinationPath, $fileName); // uploading file to given path
                $url = 'uploads/' . $fileName;
            }
            
        }
        
       
        $post = \App\Utils\HttpRequestUtil::getInstance()
            ->post_data('update_profile',[
                'token' => Session::get('user')->token,
                'username' => $request->input('name') ,
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'avatar' => $url
            ],
            $this->app->app_app_secret);    
        
        $response = json_decode($post);
        
        if( \App\Utils\Messages::validateErrors($response) ){
            Session::flash('message', \App\Utils\Messages::customMessage( 2002 ));
            return back();
        }else{
            Session::flash('message', \App\Utils\Messages::getMessage( $response ));
            return back();
        }
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
