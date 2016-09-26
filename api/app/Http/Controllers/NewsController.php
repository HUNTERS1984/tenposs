<?php

namespace App\Http\Controllers;

use App\Models\NewCat;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\News;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;
use App\Utils\UrlHelper;

class NewsController extends Controller
{
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function news_cat()
    {

        $check_items = array('app_id', 'store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_news_cat');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        //create key redis
        $key = sprintf(Config::get('api.cache_news_cat'), Input::get('app_id'), Input::get('store_id'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data=null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $app = NewCat::where('store_id', Input::get('store_id'))->whereNull('deleted_at')->select(['id', 'name'])->get()->toArray();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['news_categories'] = $app;
        if ($app != null && count($app) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }

    public function index(Request $request)
    {
        $check_items = array('app_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_news');
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
        $category_id = Input::get('category_id');
        $skip = (Input::get('pageindex') - 1) * Input::get('pagesize');
        //create key redis
        $key = sprintf(Config::get('api.cache_news'), Input::get('app_id'), $category_id, Input::get('pageindex'), Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            if ($category_id > 0)
                $total_news = News::where('new_category_id',$category_id)->count();
            else
                $total_news = News::all()->count();

            $news = [];
            if ($total_news > 0) {
                if ($category_id > 0)
                    $news = News::where('new_category_id', $category_id)->whereNull('deleted_at')->skip($skip)->take(Input::get('pagesize'))->orderBy('date', 'desc')->get()->toArray();
                else
                    $news = News::whereNull('deleted_at')->skip($skip)->take(Input::get('pagesize'))->orderBy('date', 'desc')->get()->toArray();
            }
            for ($i = 0; $i < count($news); $i++) {
                $news[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $news[$i]['image_url']);
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['news'] = $news;
        $this->body['data']['total_news'] = $total_news;
        if ($total_news > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }
}
