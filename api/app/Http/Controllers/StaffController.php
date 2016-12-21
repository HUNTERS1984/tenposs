<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\StaffCategory;
use App\Models\Store;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;
use App\Utils\UrlHelper;

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
            $staff_categories = StaffCategory::where('store_id', Input::get('store_id'))->whereNull('deleted_at')->orderBy('id', 'desc')->select(['id', 'name'])->get()->toArray();
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
        $category_id = Input::get('category_id');

        //create key
        $key = sprintf(Config::get('api.cache_staff'), Input::get('app_id'), $category_id, Input::get('pageindex'), Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $staffs = [];
            if ($category_id > 0) {
                $total_staffs = Staff::where('staff_category_id', Input::get('category_id'))->whereNull('deleted_at')->orderBy('updated_at', 'desc')->count();
                if ($total_staffs > 0) {
                    $staffs = Staff::where('staff_category_id', Input::get('category_id'))->with('staff_categories')->whereNull('deleted_at')->orderBy('updated_at', 'desc')->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
                }
            } else {
                $total_staffs = 0;
                $stores = Store::whereAppId($app['id'])->get();

                if ($stores) {
                    $staff_cat = StaffCategory::whereIn('store_id', $stores->pluck('id')->toArray())->orderBy('id', 'DESC')->whereNull('deleted_at')->get();

                    if (count($staff_cat) > 0) {
                        $total_staffs = Staff::whereIn('staff_category_id', $staff_cat->pluck('id')->toArray())->whereNull('deleted_at')->count();
                    }
                    if ($total_staffs > 0) {
                        $staffs = Staff::whereIn('staff_category_id', $staff_cat->pluck('id')->toArray())->with('staff_categories')->whereNull('deleted_at')->skip($skip)->take(Input::get('pagesize'))->orderBy('updated_at', 'desc')->get()->toArray();
                    }

                }

            }

            for ($i = 0; $i < count($staffs); $i++) {
                $staffs[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $staffs[$i]['image_url']);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['staffs'] = $staffs;
        $this->body['data']['total_staffs'] = $total_staffs;
        if ($total_staffs > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }

    public function staff_detail()
    {

        $check_items = array('app_id', 'id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_staff_detail');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        //create key
        $key = sprintf(Config::get('api.cache_staff_detail'), Input::get('app_id'), Input::get('id'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);

        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
//            $staffs = Staff::where('id', Input::get('id'))->whereNull('deleted_at')->with('staff_categories')->get();

            $staffs = DB::table('staffs')
                ->leftJoin('staff_categories', 'staff_categories.id', '=', 'staffs.staff_category_id')
                ->where('staffs.id', Input::get('id'))
                ->whereNull('staffs.deleted_at')
                ->select('staffs.*', 'staff_categories.name AS staff_category_name')
                ->get();

//            if (count($staffs) > 0 && array_key_exists('image_url', $staffs))
            if (count($staffs) > 0)
                $staffs[0]->image_url = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $staffs[0]->image_url);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['staffs'] = $staffs;
        if (count($staffs) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }
}
