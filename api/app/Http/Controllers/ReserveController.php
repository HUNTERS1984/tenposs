<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
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

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function index(Request $request) {

        $check_items = array('app_id','store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_reserve');
        print_r($check_sig_items);
        // check app_id in database
        $app = $this->_topRepository->get_app_info(Input::get('app_id'));
        if (!$app)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        try {
            $reserve = Reserve::find(Input::get('store_id'));

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['reserve'] = $reserve;
        return $this->output($this->body);
    }
}
