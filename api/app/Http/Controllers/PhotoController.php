<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\Store;
use Illuminate\Support\Facades\Redis;
use Mail;
use App\Address;
use DB;
use Illuminate\Support\Facades\Config;
use App\Utils\UrlHelper;

class PhotoController extends Controller
{
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function photo_cat()
    {

        $check_items = array('app_id', 'store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_photo_cat');
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
        $key = sprintf(Config::get('api.cache_photo_cat'), Input::get('app_id'), Input::get('store_id'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $app = PhotoCat::where('store_id', Input::get('store_id'))->whereNull('deleted_at')->orderBy('id', 'desc')->select(['id', 'name'])->get()->toArray();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['photo_categories'] = $app;
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
        $check_sig_items = Config::get('api.sig_photo');
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
        $key = sprintf(Config::get('api.cache_photos'), Input::get('app_id'), Input::get('category_id'), Input::get('pageindex'),Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        $category_id = Input::get('category_id');
        try {

            $photos = [];
            if ($category_id > 0) {
                $total_photos = Photo::where('photo_category_id', Input::get('category_id'))->whereNull('deleted_at')->count();
                if ($total_photos > 0) {
                    $photos = Photo::where('photo_category_id', Input::get('category_id'))->whereNull('deleted_at')->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
                }
            } 
            else {
                $total_photos = 0;
                $stores = Store::whereAppId($app['id'])->get();

                if ($stores) {
                    $photo_cat = PhotoCat::whereIn('store_id', $stores->pluck('id')->toArray())->orderBy('id', 'DESC')->whereNull('deleted_at')->get();

                    if (count($photo_cat) > 0) {
                        $total_photos = Photo::whereIn('photo_category_id',$photo_cat->pluck('id')->toArray())->whereNull('deleted_at')->count();            
                    }
                    if ($total_photos > 0)
                    {
                        $photos = Photo::whereIn('photo_category_id',$photo_cat->pluck('id')->toArray())->whereNull('deleted_at')->skip($skip)->take(Input::get('pagesize'))->orderBy('updated_at', 'desc')->get()->toArray();
                    }        

                }
                    
            }   
                
            for ($i = 0; $i < count($photos); $i++) {
                $photos[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $photos[$i]['image_url']);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['photos'] = $photos;
        $this->body['data']['total_photos'] = $total_photos;

        if ($total_photos > 0) { // set cache reiis
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }

}
