<?php

namespace App\Http\Controllers;

use App\Utils\HttpRequestUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Curl\Curl;
define('TOTAL_COUPON', 10);

class CouponController extends Controller
{
    public function index()
    {
        $page_number = 1;
        $app_info = $this->app_info;
        $items_data = array();
        $items_total_data = 0;
        $total_page = 0;
        $items = HttpRequestUtil::getInstance()->get_data('coupon',
            ['app_id' => $this->app->app_app_id,
                'store_id' => 1,
                'pageindex' => 1,
                'pagesize' => TOTAL_COUPON],
            $this->app->app_app_secret);
        if (!empty($items)) {
            $items = json_decode($items);
            if ($items->code == '1000') {
                $items_data = $items->data->coupons;
                $items_total_data = $items->data->total_coupons;
                $total_page = ceil($items_total_data / TOTAL_COUPON);
            }

        }
//        dd($items_data);
        return view('coupons.index', compact('app_info', 'items_data', 'items_total_data', 'total_page', 'page_number'));
    }


    public function get_data()
    {
        $page_number = $this->request->page;
        $type = $this->request->type;
        $items_data = array();
        $total_page = 0;

        if (empty($page_number))
            $page_number = 1;
        $items = HttpRequestUtil::getInstance()->get_data('coupon',
            ['app_id' => $this->app->app_app_id,
                'store_id' => 1,
                'pageindex' => $page_number,
                'pagesize' => TOTAL_COUPON],
            $this->app->app_app_secret);

        if (!empty($items)) {
            $items = json_decode($items);
            if ($items->code == '1000') {
                $items_data = $items->data->coupons;
                $items_total_data = $items->data->total_coupons;
                $total_page = ceil($items_total_data / TOTAL_COUPON);
            }
        }
        if ($type == 'load_more')
            return Response::json(array('items_data' => $items_data, 'total_page' => $total_page, 'page_number' => $page_number));
//            $returnHTML = view('menu.element_item_more')->with(compact('items_data','total_page','page_number'))->render();
        else
            return "";
    }

    public function detail($id)
    {

        $curl = new Curl();
        if( Session::has('user') ){

            $curl->setHeader('Authorization','Bearer '.Session::get('user')->token);
            $curl->get( 'https://api.ten-po.com/api/v2/coupon_detail_login' ,array(
                'app_id' => $this->app->app_app_id,
                'id' => $id,
            ));
        }else{
            $curl->get( 'https://api.ten-po.com/api/v2/coupon_detail_login' ,array(
                'app_id' => $this->app->app_app_id,
                'id' => $id,
            ));
        }

        if( isset($curl->response->code) && $curl->response->code == 1000 ){
            $items_detail_data = $curl->response->data->coupons;
            return view('coupons.detail', array(
                'app_info' => $this->app_info ,
                'items_detail_data' => $items_detail_data
            ));
        }

        return back();
    }

}
