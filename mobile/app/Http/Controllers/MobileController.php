<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Auth;
use \Curl\Curl;


class MobileController extends Controller
{

    public function getFirstSideMenu(){
        $pageOnFirstScreen = null;
        foreach( $this->app_info->data->side_menu as $menu  ){
            $itemFirstMenu = \App\Utils\Menus::page($menu->id);
            if( $itemFirstMenu['display'] ){
                $pageOnFirstScreen = $itemFirstMenu;
                break;
            }
        }
        return $itemFirstMenu['href'];
    }
    public function redirectToFirstMenu(){
        return redirect( $this->getFirstSideMenu() );
    }

    public function index(Request $request){
        if( ! Session::has('user') ){
            return view('login',array(
                'app_info' => $this->app_info
            ));
        }
        return redirect( $this->getFirstSideMenu() );
    }
    
    public function chat(){
        return view( 'chat',
            array(
                'app_info' => $this->app_info
            ));
    }

    public function home(Request $request){
        $appTop = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('top',[
                'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);

        return view('index',
            [
                'app_info' => $this->app_info ,
                'app_top' => json_decode($appTop),

            ]);
    }
    
    public function configuration(){

        $curl = new Curl();
        $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
        $curl->get( 'https://apinotification.ten-po.com/v1/user/get_push_setting' );

        if( isset($curl->response->code) && $curl->response->code == 1000 ){
            return view('configurations',
                [
                    'configs' => $curl->response->data,
                    'app_info' => $this->app_info
                ]);
        }
        Session::flash('message', array( 'class' => 'alert-danger', 'detail' => 'Error!' ));
        return back();

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

            $arrParams['app_id'] = $this->app->app_app_id;
            $curl = new Curl();
            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl->post( 'https://apinotification.ten-po.com/v1/user/set_push_setting',$arrParams );

            if( isset($curl->response->code) && $curl->response->code){
                return response()->json(['success' => true ]);
            }
            return response()->json(['success' => false ]);

        }   
    }
    
    public function userPrivacy(){
        return view( 'user_privacy', ['app_info' => $this->app_info ] );
    }
    
    public function companyInfo(){
        return view( 'company_info', ['app_info' => $this->app_info ] );
    }
    
}
