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
    
    public function configuration(){
        
        $get = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('get_push_setting',[
                'token' => Session::get('user')->token
            ],
            $this->app->app_app_secret);    
        
        $response = json_decode($get);
   
        if( \App\Utils\Messages::validateErrors($response) ){
            return view('configurations', 
            [ 
                'configs' => $response,
                'app_info' => $this->app_info
            ]);
        }else{
            Session::flash('message', \App\Utils\Messages::customMessage( 2001 ));
            return back();
        }
    }
    
    public function configurationSave(Request $request){
        if( $request->ajax() ){
            $arrKeys = ['ranking','news','coupon','chat' ];
            $arrParams = $request->all();
            foreach( $arrParams as $key => $value ){
                if( in_array( $key, $arrKeys ) ){
                    if( $value == 'true'){
                        $arrParams[$key] = 1;
                    }else{
                        $arrParams[$key] = 0;
                    }
                } 
            }
            
            $arrParams['token'] = Session::get('user')->token;
            
            $get = \App\Utils\HttpRequestUtil::getInstance()
                ->post_data('set_push_setting',
                    $arrParams,
                    $this->app->app_app_secret);    
            
            $response = json_decode($get);
            
            if( \App\Utils\Messages::validateErrors($response) ){
                return response()->json($response);
            }else{
                return response()->json(['success' => false ]);
            }
            
        }   
    }
    
    public function userPrivacy(){
        return view( 'user_privacy', ['app_info' => $this->app_info ] );
    }
    
    public function companyInfo(){
        return view( 'company_info', ['app_info' => $this->app_info ] );
    }
    
}
