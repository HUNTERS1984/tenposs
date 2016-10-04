<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Auth;


class MobileController extends Controller
{
  
    public function index(Request $request){
 
        $appTop = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('top',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);    
            
        return view('index', 
        [ 
            'app_info' => $this->app_info ,
            'app_top' => json_decode($appTop),
            
        ]);
    }
    
    public function chat(){
        return view( 'chat', ['app_info' => $this->app_info] );
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
                'profile' => $response,
                'app_info' => $this->app_info
            ]);
        }else{
            Session::flash('message', \App\Utils\Messages::customMessage( 2001 ));
            return back();
        }
        

    }
    
    public function profilePost( Request $request ){
        
    }
    
    public function configuration(){
        
        $get = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('get_push_setting',[
                'token' => Session::get('user')->token
            ],
            $this->app->app_app_secret);    
        
        $response = json_decode($get);
        //dd($response);
        if( \App\Utils\Messages::validateErrors($response) ){
            return view('configurations', 
            [ 
                'config' => $response,
                'app_info' => $this->app_info
            ]);
        }else{
            Session::flash('message', \App\Utils\Messages::customMessage( 2001 ));
            return back();
        }
    }
    
}
