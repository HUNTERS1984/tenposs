<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;


class ReserveController extends Controller
{

    public function index(){
    	$appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);

        $app_info = json_decode($appInfos);
        $reserve_arr = [];

        foreach($app_info->data->stores as $store){
        	$reserve_json = \App\Utils\HttpRequestUtil::getInstance()
				->get_data('reserve',['app_id'=>$this->app->app_app_id,'store_id'=>$store->id],$this->app->app_app_secret);
            $reserve_json_decode = json_decode($reserve_json);
            if($reserve_json_decode->data->reserve != null){
                array_push($reserve_arr,json_decode($reserve_json));
            }
        }
        return view('reserve',compact('app_info','reserve_arr'));
    }
}
