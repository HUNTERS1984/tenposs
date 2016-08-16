<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\News;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;

class NewsController extends Controller
{
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function index(Request $request) {
        $check_items = array('app_id','store_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_news');
        // check app_id in database
        $app = $this->_topRepository->get_app_info(Input::get('app_id'));
        if (!$app)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);

        $skip = (Input::get('pageindex') - 1)*Input::get('pagesize');

        try {
            $total_news = News::where('store_id', Input::get('store_id'))->count();
            $news = [];
            if ($total_news > 0)
                $news = News::where('store_id', Input::get('store_id'))->skip($skip)->take(Input::get('pagesize'))->get()->toArray();

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['news'] = $news;
        $this->body['data']['total_news'] = $total_news;
        return $this->output($this->body);
    }
}
