<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Session;
use Auth;
use Validator;

class LoginController extends Controller
{
    protected $socialite;

    public function __construct(Socialite $socialite){
        parent::__construct();
        $this->socialite = $socialite;
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
        return redirect('/');
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
    
    
    
}
