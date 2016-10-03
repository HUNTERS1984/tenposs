<?php

namespace App\Http\Controllers;

use App\Utils\HttpRequestUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

define('TOTAL_ITEMS', 10);

class MenusController extends Controller
{
    protected $app;

    public function __construct()
    {

        $this->app = Session::get('app');

    }

    //
    public function index()
    {
        $app_info = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo', [
                'app_id' => $this->app->app_app_id], $this->app->app_app_secret);

        $menus = HttpRequestUtil::getInstance()->get_data('menu', [
            'app_id' => $this->app->app_app_id, 'store_id' => 1], $this->app->app_app_secret);
        $menus_data = array();
        $items_data = array();
        $items_total_data = 0;
        $total_page = 0;
        if (!empty($menus)) {
            $menus = json_decode($menus);
            if ($menus->code == '1000') {
                $menus_data = $menus->data->menus;
                if (count($menus_data) > 0) {

                    $items = HttpRequestUtil::getInstance()->get_data('items',
                        ['app_id' => $this->app->app_app_id,
                            'menu_id' => $menus_data[0]->id,
                            'pageindex' => 1,
                            'pagesize' => 20],
                        $this->app->app_app_secret);
                    if (!empty($items)) {
                        $items = json_decode($items);
                        if ($items->code == '1000') {
                            $items_data = $items->data->items;
                            $items_total_data = $items->data->total_items;
                            $total_page = ceil($items_total_data / TOTAL_ITEMS);
                        }
                    }

                }
            }
        }
        return view('menu.index', compact('app_info', 'menus_data', 'items_data', 'items_total_data', 'total_page'));
    }

    public function detail()
    {
        $app_info = \App\Utils\HttpRequestUtil::getInstance()
            ->get_data('appinfo', [
                'app_id' => $this->app->app_app_id], $this->app->app_app_secret);

        $items_detail = HttpRequestUtil::getInstance()->get_data('item_detail',
            [
                'app_id' => $this->app->app_app_id,
                'item_id' => 2,
            ]
            , $this->app->app_app_secret);
        if (!empty($items_detail)) {
            $items_detail = json_decode($items_detail);
            if ($items_detail->code == '1000') {
                $items_detail_data = $items_detail->data->items[0];
                dd($items_detail_data);
                $items_relate = HttpRequestUtil::getInstance()->get_data('item_relate',
                    [
                        'app_id' => $this->app->app_app_id,
                        'item_id' => 2
                    ], $this->app->app_app_secret);
                if (!empty($items_relate)) {
                    $items_relate = json_decode($items_relate);
                    if ($items_relate->code == '1000') {
                        $items_relate_data = $items_relate->data->items;
                    }
                }
            }
        }
        return view('menu.detail', compact('app_info'));
    }
}
