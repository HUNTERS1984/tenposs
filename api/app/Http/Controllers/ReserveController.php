<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Repositories\Contracts\ReservesRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\Reserve;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;

class ReserveController extends Controller
{

    protected $request;
    protected $_topRepository;
    protected $_reserveRepository;

    public function __construct(TopsRepositoryInterface $ur, ReservesRepositoryInterface $rr, Request $request)
    {
        $this->_topRepository = $ur;
        $this->_reserveRepository = $rr;
        $this->request = $request;
    }

    public function index() {

        $check_items = array('app_id','store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_reserve');

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
        $key = sprintf(Config::get('api.cache_reserve'), Input::get('app_id'), Input::get('store_id'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $reserve = $this->_reserveRepository->getList(Input::get('store_id'));

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['reserve'] = $reserve;
        if ($reserve != null && count($reserve) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }
}
