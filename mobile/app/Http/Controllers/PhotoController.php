<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;

define('PAGESIZE', 20);
define('STEPSHOW', 3);

class PhotoController extends Controller
{
    public function index(){
    	$appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);

        $app_info = json_decode($appInfos);
        $photo_cate = [];
        $photo_detail = [];


        foreach($app_info->data->stores as $store){
        	$photoCate = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('photo_cat',['app_id'=>$this->app->app_app_id,'store_id'=>$store->id],$this->app->app_app_secret);
            $photoCate_decode = json_decode($photoCate);
            if($photoCate_decode->data->photo_categories != null){
                array_push($photo_cate,json_decode($photoCate));
            }
        }
        foreach($photo_cate as $cate){
        	if(isset($cate)){
        		foreach($cate->data->photo_categories as $item){
        			$photoDetail = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('photo',['app_id'=>$this->app->app_app_id,'category_id'=>$item->id,'pageindex'=>1,'pagesize'=>PAGESIZE],$this->app->app_app_secret);
                        $photoDetail_decode = json_decode($photoDetail);
                        if($photoDetail_decode->data->photos != null){
			                array_push($photo_detail,$photoDetail_decode);
			            }
        		}
        	}
        }
        return view('photo',compact('app_info','photo_cate','photo_detail'))->with('pagesize',PAGESIZE);
    }

    public function ajaxLoadmore(Request $request){
        if($request->ajax()){
            $pagesize = $request->input('pagesize');
            $cate_id = $request->input('cate');
            $pagesize = $pagesize + STEPSHOW;
            $photo = \App\Utils\HttpRequestUtil::getInstance()->get_data('photo',['app_id'=>$this->app->app_app_id,'category_id'=>$cate_id,'pageindex'=>1,'pagesize'=>$pagesize],$this->app->app_app_secret);
            $photo_detail = json_decode($photo);
            if(count($photo_detail->data->photos) < $photo_detail->data->total_photos){
                $status = 'green';
            }else{
                $status = 'red';
            }
            $view = view('ajax.photoajax', compact('pagesize','photo_detail'))->render();
            return response()->json(['msg'=>$view,'status'=>$status,'pagesize'=>$pagesize]);
            
        }
    }
}
