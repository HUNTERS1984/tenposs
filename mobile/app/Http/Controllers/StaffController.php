<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;

define('PAGESIZE', 20);
define('STEPSHOW', 1);

class StaffController extends Controller
{

    public function index(){
    	$appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);
        $app_info = json_decode($appInfos);

        $staff_cate = [];
        $staff_detail = [];

        foreach($app_info->data->stores as $store){
        	$staff_cate_json = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('staff_categories',['app_id'=>$this->app->app_app_id,'store_id'=>$store->id],$this->app->app_app_secret);
            
            $staff_cate_decode = json_decode($staff_cate_json);
            if($staff_cate_decode->data->staff_categories != null){
                array_push($staff_cate,$staff_cate_decode);
            }
        }

        foreach($staff_cate as $cate){
            if(isset($cate)){
                foreach ($cate->data->staff_categories as $item){
                    $staff = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('staffs',['app_id'=>$this->app->app_app_id,'category_id'=>$item->id,'pageindex'=>1,'pagesize'=>PAGESIZE],$this->app->app_app_secret);
                        $staff_decode = json_decode($staff);
                        if($staff_decode->data->staffs != null){
                            array_push($staff_detail,$staff_decode);
                        }
                }
            }
        }
        return view('staff',compact('app_info','staff_cate','staff_detail'))->with('pagesize',PAGESIZE);
    }

    public function getDetail($id){
        $appInfos = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo',[
            'app_id' => $this->app->app_app_id ],$this->app->app_app_secret);

        $staff_detail = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('staff_detail',['app_id'=>$this->app->app_app_id,'id'=>$id],$this->app->app_app_secret);
        $app_info = json_decode($appInfos);
        $detail = json_decode($staff_detail);
        // dd($detail);
        return view('staff_detail',compact('app_info','detail'));

    }

    public function ajaxLoadmore(Request $request){
        if($request->ajax()){
            $pagesize = $request->input('pagesize');
            $cate_id = $request->input('cate');
            $pagesize = $pagesize + STEPSHOW;
            $staff = \App\Utils\HttpRequestUtil::getInstance()->get_data('staffs',['app_id'=>$this->app->app_app_id,'category_id'=>$cate_id,'pageindex'=>1,'pagesize'=>$pagesize],$this->app->app_app_secret);
            $staff_detail = json_decode($staff);

            if(count($news_detail->data->staffs) < $news_detail->data->total_staffs){
                $status = 'green';
            }else{
                $status = 'red';
            }
            $view = view('ajax.staffajax', compact('pagesize','staff_detail'))->render();
            return response()->json(['msg'=>$view,'status'=>$status,'pagesize'=>$pagesize]);
        }
    }
}
