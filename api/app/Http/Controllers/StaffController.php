<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\StaffCategory;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;

class StaffController extends Controller
{
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function staff_categories(Request $request)
    {

        $check_items = array('app_id', 'store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_staff_category');
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
        $key = sprintf(Config::get('api.cache_staff_categories'), Input::get('app_id'), Input::get('store_id'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $staff_categories = StaffCategory::where('store_id', Input::get('store_id'))->select(['id', 'name'])->get()->toArray();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
        $this->body['data']['staff_categories'] = $staff_categories;
        if ($staff_categories != null && count($staff_categories) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }

    public function staffs()
    {

        $check_items = array('app_id', 'category_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_staffs');
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
        $key = sprintf(Config::get('api.cache_staff'), Input::get('app_id'), Input::get('category_id'), Input::get('pageindex'), Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $total_staffs = StaffCategory::find(Input::get('category_id'))->staffs()->count();
            $staffs = [];
            if ($total_staffs > 0)
                $staffs = StaffCategory::find(Input::get('category_id'))->staffs()->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
            for ($i = 0; $i < count($staffs); $i++) {
                $staffs[$i]['image_url'] = Config::get('api.media_base_url').$staffs[$i]['image_url'];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e);
            return $this->error(9999);
        }

        $this->body['data']['staffs'] = $staffs;
        $this->body['data']['total_staffs'] = $total_staffs;
        if ($total_staffs > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }
}
