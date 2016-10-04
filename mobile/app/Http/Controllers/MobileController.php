<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Auth;


class MobileController extends Controller
{
    //
    protected $app;
    public function __construct(){
        
        $this->app = Session::get('app') ;
        
    }
    
    
    public function index(Request $request, $name =  null){
 
        $appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);
            
        $appTop = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('top',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);    
            
        //dd(json_decode($appTop));
        return view('index', 
        [ 
            'app_info' => json_decode($appInfos),
            'app_top' => json_decode($appTop),
            
        ] );
    }

}
