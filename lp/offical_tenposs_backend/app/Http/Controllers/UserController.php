<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use Validator;
use Auth;
use Session;
use cURL;
use Mail;

class UserController extends Controller
{
    //
    protected $url_register = 'https://auth.ten-po.com/auth/register';
    protected $url_login = 'https://auth.ten-po.com/auth/login';
    
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
        
        $response = cURL::post($this->url_login, 
            [
                'email' => $request->input('email'), 
                'password' => $request->input('password'),
                'role' => 'client'
            ]
        );
        
        $response = json_decode( $response->body );
        
        if( $response->code == 1000 ){
            Session::put('user', $response->data);
            return redirect()->route('user.dashboard');
        }
        
        return back()->withErrors('ログインに失敗しました');
 
    }
    
    public function logout(){
        Session::forget('user');
        return redirect('/');
    }
    
    
    public function getRegister(){
        return view('pages.signup');
    }
    
    public function postRegister(Request $request)
    {
        
        
        $validator = Validator::make( $request->all() , [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            //'password_confirmation' => 'required|min:6|confirmed',
            //'agreement' => 'required',
        ]);


        if ( $validator->fails() ) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
        // send to API auth
        $response = cURL::post($this->url_register, 
            [
                'email' => $request->input('email'), 
                'password' => $request->input('password'),
                'role' => 'client'
            ]
        );
        
        $response = json_decode( $response->body );
        
        if( $response->code == 1000 ){
            return redirect()->route('user.dashboard');
        }
        
        $url_authorize = '';
        if( $response->code == 1000 ){
            $url_authorize = route('user.activate', $response->data );
        }

        // Send email verifined
        Mail::send('emails.register',
			 array( 'url_authorize' => $url_authorize)
			 ,function($message) use ( $request ) {
				 $message->from( config('mail.from')['address'], config('mail.from')['name'] );
				 $message->to( [$request->input('email') , config('mail.admin_email')] )
					 //->cc()
					 ->subject('【Tenposs】新規登録のお知らせ');
			 });   
       
               
        
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
