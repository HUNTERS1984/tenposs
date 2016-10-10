<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;

define('PAGESIZE', 20);
define('STEPSHOW', 1);

class NewsController extends Controller
{

    public function index(){
    	$appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);
        $app_info = json_decode($appInfos);

        $news_cate = [];
        $news_detail = [];

        foreach($app_info->data->stores as $store){
        	$new_cate = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('news_cat',['app_id'=>$this->app->app_app_id,'store_id'=>$store->id],$this->app->app_app_secret);
            $new_cate_decode = json_decode($new_cate);
            if($new_cate_decode->data->news_categories != null){
                array_push($news_cate,json_decode($new_cate));
            }
        }

        foreach($news_cate as $cate){
            if(isset($cate)){
                foreach ($cate->data->news_categories as $item){
                    $new = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('news',['app_id'=>$this->app->app_app_id,'category_id'=>$item->id,'pageindex'=>1,'pagesize'=>PAGESIZE],$this->app->app_app_secret);
                        $new_decode = json_decode($new);
                        if($new_decode->data->news != null){
                            array_push($news_detail,$new_decode);
                        }
                }
            }
        }
        // $newtest = \App\Utils\HttpRequestUtil::getInstance()
        //                 ->get_data('news',['app_id'=>$this->app->app_app_id,'category_id'=>1,'pageindex'=>1,'pagesize'=>PAGESIZE],$this->app->app_app_secret);
        // $dec = json_decode($newtest);
        // dd($dec);
    	return view('news',compact('app_info','news_cate','news_detail'))->with('pagesize',PAGESIZE);
    }

    public function getDetail($id){
        $appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);

        $appTop = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('top',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);

        $news_detail = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('news_detail',['app_id'=>$this->app->app_app_id,'id'=>$id],$this->app->app_app_secret);
        $app_info = json_decode($appInfos);
        $app_top = json_decode($appTop);
        $detail = json_decode($news_detail);
        return view('news_detail',compact('app_info','detail','app_top'));
    }

    public function ajaxLoadmore(Request $request){
        if($request->ajax()){
            $pagesize = $request->input('pagesize');
            $cate_id = $request->input('cate');
            $pagesize = $pagesize + STEPSHOW;
            $new = \App\Utils\HttpRequestUtil::getInstance()->get_data('news',['app_id'=>$this->app->app_app_id,'category_id'=>$cate_id,'pageindex'=>1,'pagesize'=>$pagesize],$this->app->app_app_secret);
            $news_detail = json_decode($new);
            if(count($news_detail->data->news) < $news_detail->data->total_news){
                $status = 'green';
            }else{
                $status = 'red';
            }
            $view = view('ajax.newsajax', compact('pagesize','news_detail'))->render();
            return response()->json(['msg'=>$view,'status'=>$status,'pagesize'=>$pagesize]);
            
        }
    }
}
