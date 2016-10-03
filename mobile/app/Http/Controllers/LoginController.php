<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Session;
use Auth;

class LoginController extends Controller
{
    //
    protected $socialite;
    protected $app;
    
    
    public function __construct(Socialite $socialite){
       $this->socialite = $socialite;
       $this->app = Session::get('app');
    }
    
    public function logout(){
        Session::forget('user');
        return redirect('/');
    }
    
    public function signup(){
        return view('signup_email');
    }
    
    public function signupPost(Request $request){
        $post = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('signup',[
                     'app_id' => $this->app->app_app_id,
                     'email' =>  $request->input('email') ,
                     'name' => $request->input('name') ,
                     'password' => $request->input('password') ,
                ],
                $this->app->app_app_secret); 
                
        $response = json_decode($post);
        
        if ( $response && $response->code == 1000  ){
            Session::put('user', $response->data);
            return redirect('/');
        }elseif ( $response->code == 9996 ){
            Session::flash('message', array('class' => 'alert-danger', 'detail' => $response->message ));
            return back();
        }
       
    }
    
    public function getSocialAuth( $provider = null ){
        if(!config("services.$provider")) 
            abort('404'); //just to handle providers that doesn't exist
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
                
            $response = json_decode($login);
          
            if ( $response && $response->code == 1000  ){
                Session::put('user', $response->data);
                return redirect('/');
            }else{
                dd('Error');
            }
            
           
        }else{
            return 'something went wrong';
        }
    }
}
