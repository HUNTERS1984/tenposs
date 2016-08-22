<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use App\Http\Requests;

use Illuminate\Support\Facades\Config;

class CouponController extends Controller
{
    //
    //
    protected $request;
    protected $_topRepository;
    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    //
    public function index()
    {
        $check_items = array('app_id', 'time', 'store_id', 'pageindex', 'pagesize', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_coupon');
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
        //create key redis
        $key = sprintf(Config::get('api.cache_photos'), Input::get('app_id'), Input::get('store_id'), Input::get('pageindex'),Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try
        {
            $coupon = [];
            if (Input::get('store_id') == 0){
                $total_coupon = Coupon::count();
                if ($total_coupon > 0)
                    $coupon = Coupon::skip($skip)->take(Input::get('pagesize'))->get()->toArray();
            }
            else {
                $total_coupon = Coupon::where('store_id', Input::get('store_id'))->count();
                if ($total_coupon > 0)
                    $coupon = Coupon::where('store_id', Input::get('store_id'))->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
            }
        }
        catch (QueryException $e)
        {
            return $this->error(9999);
        }
        $this->body['data']['coupons'] = $coupon;
        $this->body['data']['total_coupons'] = $total_coupon;
        if ($total_coupon > 0) { // set cache reiis
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);

    }
}
