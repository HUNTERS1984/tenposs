<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class HomeController extends Controller
{
    public function getIndex(){
    	// $app = DB::table('apps')
     //            ->where('id',$this->app_id)
     //            ->first();
     //    if( !$app ){
     //        abort(404);
     //    }
        $appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2' ],'33d3afaeefdffe55b185359f901d15e4');

         dd($appInfos);

         $menu = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('menu',[
            'app_id' => $app->app_app_id,'store_id'=>$app->app_store_id ],$app->app_app_secret);


        // $item_recentry = \App\Utils\HttpRequestUtil::getInstance()->get_data('items',[''],$app->app_app_secret)
    }
}
