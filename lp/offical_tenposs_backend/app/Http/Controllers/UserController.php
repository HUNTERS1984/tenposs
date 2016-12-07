<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use Validator;
use Auth;
use Session;
use cURL;
use Mail;
use JWTAuth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    //
    protected $jwt_auth;
    protected $url_register = 'https://auth.ten-po.com/v1/auth/register';
    protected $url_login = 'https://auth.ten-po.com/v1/auth/login';
    protected $url_logout = 'https://auth.ten-po.com/v1/auth/signout';

    public function __construct(){
        
    }
    
    public function getLogin(){
        return view('pages.login');
        
    }
    public function postLogin(Request $request){
        
        $validator = Validator::make( $request->all() , [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
        
        if ( $validator->fails() ) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $requestLogin = cURL::newRequest('post', Config::get('api.api_auth_login'),[
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'role' => 'client',
            'platform' => 'web',
        ])->setHeader('Authorization',  'Basic '. base64_encode( config('jwt.jwt_admin').':'.config('jwt.jwt_admin_password') ));


        $responseLogin = $requestLogin->send();

        $responseLogin = json_decode($responseLogin->body);
       
        if( !empty($responseLogin) && isset( $responseLogin->code ) && $responseLogin->code == 1000 ){
            Session::put('jwt_token',$responseLogin->data);
            //dd($responseLogin);
            if ($responseLogin->data->is_active)
                return redirect()->route('admin.client.global');
            else
                return redirect()->route('user.dashboard');
            //return redirect()->intended();
        }
        return back()->withErrors( 'ログインできません' )->withInput();
    }
    
    public function logout(){
        Session::forget('jwt_token');
        Session::forget('user');
        return redirect()->route('login');
    }
    
    
    public function getRegister(){
        return view('pages.signup');
    }
    
    public function postRegister(Request $request)
    {

        $validator = Validator::make( $request->all() , [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        if ( $validator->fails() ) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
        // send to API auth

        $requestRegister = cURL::newRequest('post', $this->url_register,[
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'role' => 'client',
            'platform' => 'web'
        ])->setHeader('Authorization',  'Basic '. base64_encode( config('jwt.jwt_admin').':'.config('jwt.jwt_admin_password') ));


        $responseRegister = $requestRegister->send();
        $responseRegister = json_decode($responseRegister->body);

        if( !empty($responseRegister) && isset( $responseRegister->code ) && $responseRegister->code == 1000 ){
            Session::put('jwt_token',$responseRegister->data);
            return redirect()->route('user.dashboard');
        }
        
        if( !empty($response) && isset( $response->code ) && $response->code == 9996 ){
            return back()->withErrors('ユーザーが存在します!')->withInput();
        }
        return back()->withErrors('登録できません!')->withInput();
        /*
        $url_authorize = '';
        Mail::send('emails.register',
			 array( 'url_authorize' => $url_authorize)
			 ,function($message) use ( $request ) {
				 $message->from( config('mail.from')['address'], config('mail.from')['name'] );
				 $message->to( [$request->input('email') , config('mail.admin_email')] )
					 //->cc()
					 ->subject('【Tenposs】新規登録のお知らせ');
			 });   
       
        */   
        
    }
    
    public function reset(){
        return view('pages.password.email_form');
    }
    
    public function sendResetLinkEmail(Request $request){
        // send mail reset
        $validator = Validator::make( $request->all() , [
            'email' => 'required|email|max:255',
        ]);


        if ( $validator->fails() ) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
        
        // Send API to send email reset link
        
        
    }
    
    // Show form reset pass by email 
    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->reset();
        }
        $email = $request->input('email');
        return view('pages.password.reset_form')
            ->with(compact('token', 'email'));
    }
    
    public function resetPost(Request $request){
        // validate password
        $validator = Validator::make( $request->all() , [
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|confirmed',
        ]);
         if ( $validator->fails() ) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
        // send token to reset
    }
 
}
