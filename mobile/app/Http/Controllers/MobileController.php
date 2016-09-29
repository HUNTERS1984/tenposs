<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class MobileController extends Controller
{
    //
    protected $app_id;
    public function __construct(){
        $this->app_id = 1;
    }
    
    
    public function index(Request $request){
        $app = DB::table('apps')
                ->where('id',$this->app_id)
                ->first();
        if( !$app ){
            abort(404);
        }
        
        $appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $app->app_app_id ],$app->app_app_secret);
            
        $appTop = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('top',[
            'app_id' => $app->app_app_id ],$app->app_app_secret);    
            
        //dd(json_decode($appTop));
        return view('index', 
        [ 
            'app_info' => json_decode($appInfos),
            'app_top' => json_decode($appTop),
            
        ] );
    }
}
