<?php

namespace App\Http\Controllers;

use App\Utils\HttpRequestUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

define('TOTAL_ITEMS', 20);

class MenusController extends Controller
{
    //
    public function index()
    {

        $page_number = $this->request->page;
        $menu_id = $this->request->menu_id;
        $app_info = $this->app_info;
        
        $menus = [];
        $items_detail = [];
        $menu_data = array();

        foreach($app_info->data->stores as $store){
            $menu = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('menu',['app_id'=>$this->app->app_app_id,'store_id'=>$store->id],$this->app->app_app_secret);
            $menu_decode = json_decode($menu);
            if($menu_decode->data->menus != null){
                array_push($menus,json_decode($menu));
            }
        }

        foreach($menus as $cate){
            if(isset($cate)){
                foreach ($cate->data->menus as $item){
                    $ret = \App\Utils\HttpRequestUtil::getInstance()
                        ->get_data('items',['app_id'=>$this->app->app_app_id,'menu_id'=>$item->id,'pageindex'=>1,'pagesize'=>TOTAL_ITEMS],$this->app->app_app_secret);
                        $item_decode = json_decode($ret, true);
                        if($item_decode['data']['items'] != null){
                            $item_decode['data']['menu_id'] = $item->id;
                            $menu_data[$item->id] = $item_decode;
                            array_push($items_detail,$item_decode);
                        } else {
                            $menu_data[$item->id] = null;
                            array_push($items_detail, null);
                        }
                }
            }
        }

        return view('menus.index',compact('app_info','menus','items_detail','menu_data'))->with('pagesize',TOTAL_ITEMS);
    }


    public function ajaxLoadmore(Request $request){
        if($request->ajax()){
            $pagesize = $request->input('pagesize');
            $cate_id = $request->input('cate');
            $pagesize = $pagesize + TOTAL_ITEMS;
            $item = \App\Utils\HttpRequestUtil::getInstance()->get_data('items',['app_id'=>$this->app->app_app_id,'menu_id'=>$cate_id,'pageindex'=>$pagesize/TOTAL_ITEMS,'pagesize'=>TOTAL_ITEMS],$this->app->app_app_secret);
            $items_detail = json_decode($item, true);
            $items_detail['data']['menu_id'] = $cate_id;

            if($pagesize < $items_detail['data']['total_items']){
                $status = 'green';
            }else{
                $status = 'red';
            }
            $view = view('ajax.menuajax', compact('pagesize','items_detail','cate_id'))->render();
            return response()->json(['msg'=>$view,'status'=>$status,'pagesize'=>$pagesize, 'cate_id'=>$cate_id]);
            
        }
    }


    public function detail($id)
    {
        $app_info = $this->app_info;

        $items_detail = HttpRequestUtil::getInstance()->get_data('item_detail',
            [
                'app_id' => $this->app->app_app_id,
                'item_id' => $id
            ]
            , $this->app->app_app_secret);

       //dd(json_decode($items_detail));

        $load_more_releated = false;
        $items_detail_data = array();
        $items_relate_data = array();
        if (!empty($items_detail)) {
            $items_detail = json_decode($items_detail);

            if ($items_detail->code == '1000') {
//              print_r($items_detail);die;
                $items_detail_data = $items_detail->data->items;
                $items_relate_data = $items_detail->data->items_related;
                if ($items_detail->data->total_items_related > 9)
                    $load_more_releated = true;
//                $items_relate = HttpRequestUtil::getInstance()->get_data('item_related',
//                    [
//                        'app_id' => $this->app->app_app_id,
//                        'item_id' => $this->request->id
//                    ], $this->app->app_app_secret);
//                if (!empty($items_relate)) {
//                    dd($items_relate);
//                    $items_relate = json_decode($items_relate);
//
//                    if ($items_relate->code == '1000') {
//                        $items_relate_data = $items_relate->data->items;
//                    }
//                }
            }
        }
//        dd($items_relate_data);
        return view('menus.detail', compact('app_info', 'items_detail_data', 'items_relate_data', 'load_more_releated'));
    }

    public function related($item_id)
    {
        $app_info = $this->app_info;
        $items_data = array();
        $items_total_data = 0;
        $total_page = 0;
        $page_number = 1;
        $items = HttpRequestUtil::getInstance()->get_data('item_related',
            ['app_id' => $this->app->app_app_id,
                'item_id' => $item_id,
                'pageindex' => 1,
                'pagesize' => TOTAL_ITEMS],
            $this->app->app_app_secret);

        if (!empty($items)) {
            $items = json_decode($items);
            if ($items->code == '1000') {
                $items_data = $items->data->items;
                $items_total_data = $items->data->total_items;
                $total_page = ceil($items_total_data / TOTAL_ITEMS);
            }

        }
        //print_r($total_page);
        return view('menus.related', compact('app_info', 'items_data', 'items_total_data', 'total_page', 'page_number', 'item_id'));
    }

    public function related_get_data()
    {

        $page_number = $this->request->page;
        $item_id = $this->request->item_id;
        $type = $this->request->type;
        $items_data = array();
        $total_page = 0;

        if (empty($page_number))
            $page_number = 1;
        $items = HttpRequestUtil::getInstance()->get_data('item_related',
            ['app_id' => $this->app->app_app_id,
                'item_id' => $item_id,
                'pageindex' => $page_number,
                'pagesize' => TOTAL_ITEMS],
            $this->app->app_app_secret);
        if (!empty($items)) {
            $items = json_decode($items);
            if ($items->code == '1000') {
                $items_data = $items->data->items;
                $items_total_data = $items->data->total_items;
                $total_page = ceil($items_total_data / TOTAL_ITEMS);
            }
        }
//        print_r($total_page);die;

        if ($type == 'load_more')
            return Response::json(array('items_data' => $items_data, 'total_page' => $total_page, 'page_number' => $page_number));
//            $returnHTML = view('menu.element_item_more')->with(compact('items_data','total_page','page_number'))->render();
        else
            return "";
    }
}
