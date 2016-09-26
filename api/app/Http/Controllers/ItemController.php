<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\Menu;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;
use App\Utils\UrlHelper;

class ItemController extends Controller
{
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function menu(Request $request)
    {

        $check_items = array('app_id', 'store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_menu');
        //print_r($check_sig_items);
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        // create key
        $key = sprintf(Config::get('api.cache_menus'), Input::get('app_id'), Input::get('store_id'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $menus = Menu::where('store_id', Input::get('store_id'))->select(['id', 'name'])->orderBy('id', 'desc')->get()->toArray();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
        $this->body['data']['menus'] = $menus;
        if ($menus != null && count($menus) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }

    public function items()
    {

        $check_items = array('app_id', 'menu_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_items');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);

        $skip = (Input::get('pageindex') - 1) * Input::get('pagesize');
        //create key
        $key = sprintf(Config::get('api.cache_items'), Input::get('app_id'), Input::get('menu_id'), Input::get('pageindex'), Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $total_items = Menu::find(Input::get('menu_id'))->items()->count();
            $items = [];
            if ($total_items > 0)
                $items = Menu::find(Input::get('menu_id'))->items()->orderBy('updated_at', 'desc')->skip($skip)->take(Input::get('pagesize'))->with('rel_items')->get()->toArray();
//            dd($items);
            for ($i = 0; $i < count($items); $i++) {
                $items[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $items[$i]['image_url']);
                try {
                    $items_size = \Illuminate\Support\Facades\DB::table('item_sizes')
                        ->leftJoin('item_size_types', 'item_sizes.item_size_type_id', '=', 'item_size_types.id')
                        ->leftJoin('item_size_categories', 'item_sizes.item_size_category_id', '=', 'item_size_categories.id')
                        ->where('item_sizes.item_id', '=', $items[$i]['id'])
                        ->select('item_sizes.item_size_type_id', 'item_size_types.name AS item_size_type_name',
                            'item_sizes.item_size_category_id', 'item_size_categories.name AS item_size_category_name', 'item_sizes.value')
                        ->get();
                    $items[$i]['size'] = $items_size;
                } catch (QueryException $ex) {
                    Log::error($ex->getMessage());
                    $items[$i]['size'] = [];
                }
            }


        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['items'] = $items;
        $this->body['data']['total_items'] = $total_items;
        if ($total_items > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }

    public function item_relate()
    {

        $check_items = array('app_id', 'item_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_items');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);

        $skip = (Input::get('pageindex') - 1) * Input::get('pagesize');
        //create key
        $key = sprintf(Config::get('api.cache_items'), Input::get('app_id'), Input::get('menu_id'), Input::get('pageindex'), Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) { 
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $total_items = Menu::find(Input::get('menu_id'))->items()->count();
            $items = [];
            if ($total_items > 0)
                $items = Menu::find(Input::get('menu_id'))->items()->orderBy('updated_at', 'desc')->skip($skip)->take(Input::get('pagesize'))->with('rel_items')->get()->toArray();
//            dd($items);
            for ($i = 0; $i < count($items); $i++) {
                $items[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $items[$i]['image_url']);
                try {
                    $items_size = \Illuminate\Support\Facades\DB::table('item_sizes')
                        ->leftJoin('item_size_types', 'item_sizes.item_size_type_id', '=', 'item_size_types.id')
                        ->leftJoin('item_size_categories', 'item_sizes.item_size_category_id', '=', 'item_size_categories.id')
                        ->where('item_sizes.item_id', '=', $items[$i]['id'])
                        ->select('item_sizes.item_size_type_id', 'item_size_types.name AS item_size_type_name',
                            'item_sizes.item_size_category_id', 'item_size_categories.name AS item_size_category_name', 'item_sizes.value')
                        ->get();
                    $items[$i]['size'] = $items_size;
                } catch (QueryException $ex) {
                    Log::error($ex->getMessage());
                    $items[$i]['size'] = [];
                }
            }


        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['items'] = $items;
        $this->body['data']['total_items'] = $total_items;
        if ($total_items > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }
}
