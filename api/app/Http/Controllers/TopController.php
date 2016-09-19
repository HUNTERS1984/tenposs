<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Eloquents\NotificationRepository;
use App\Utils\RedisUtil;
use App\Utils\ValidateUtil;
use Illuminate\Support\Facades\Config;
use App\Repositories\Contracts\TopsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Photo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Mail;
use App\Address;
use DB;
use Predis\PredisException;
use Twitter;

class TopController extends Controller
{

    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }


    public function top(Request $request)
    {

        $check_items = array('app_id', 'time', 'sig');
        $check_sig_items = Config::get('api.sig_top');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));

        if (!$app)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;

//        $stores = $app->stores()->lists('id')->toArray();

        $images = $this->_topRepository->get_top_images(Input::get('app_id'));
        $news = $this->_topRepository->get_top_news(Input::get('app_id'));
        $photos = $this->_topRepository->get_top_photos(Input::get('app_id'));
        $items = $this->_topRepository->get_top_items(Input::get('app_id'));
        $contacts = $this->_topRepository->get_top_contacts(Input::get('app_id'));

        $this->body['data']['images']['top_id'] = 1;
        $this->body['data']['images']['data'] = $images;
        $this->body['data']['items']['top_id'] = 2;
        $this->body['data']['items']['data'] = $items;
        $this->body['data']['news']['top_id'] = 3;
        $this->body['data']['news']['data'] = $news;
        $this->body['data']['contact']['top_id'] = 4;
        $this->body['data']['contact']['data'] = $contacts;
        $this->body['data']['photos']['top_id'] = 5;
        $this->body['data']['photos']['data'] = $photos;



        return $this->output($this->body);
    }

    public function appinfo()
    {
        $check_items = array('app_id', 'time', 'sig');
        $check_sig_items = Config::get('api.sig_appinfo');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        try {
            // check app_id in database
            $app = $this->_topRepository->get_app_info(Input::get('app_id'));
            if ($app == null || count($app) == 0)
                return $this->error(1004);
            //validate sig
            $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
            if ($ret_sig)
                return $ret_sig;
            //creare key redis
            $key = sprintf(Config::get('api.cache_app_info'), Input::get('app_id'));
            //get data from redis
            $data = RedisUtil::getInstance()->get_cache($key);

            //check data and return data
            if ($data != null) {
                $this->body = $data;
                return $this->output($this->body);
            }
            $app_data = $app->with('app_setting', 'top_components', 'side_menu', 'stores')->select(['id', 'name', 'description', 'status', 'created_at', 'updated_at'])->first()->toArray();

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data'] = $app_data;
        if ($app_data != null && count($app_data) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }

    public function get_sig_time_test()
    {
        try {
            // check app_id in database
            $app_id = Input::get('app_id');
            $app = $this->_topRepository->get_app_info($app_id);
            if ($app == null || count($app) == 0)
                return $this->error(1004);
            $api_function = Input::get('api_function');
            $time = Input::get('time');
            $secret_key = Input::get('secret_key');
            if (empty($time))
                $time = ValidateUtil::getDateMilisecondGMT0(); //round(microtime(true) * 1000);
            if (empty($secret_key))
                $secret_key = $app['app_app_secret'];
            $str_sig = '';
            $str_param = true;
            $str_hash = [];
            switch ($api_function) {
                case 'top': {
                    $str_sig = hash('sha256', $app_id . $time . $secret_key);
                    $str_hash = Config::get('api.sig_top');
                    break;
                }
                case 'appinfo': {
                    $str_sig = hash('sha256', $app_id . $time .$secret_key);
                    $str_hash = Config::get('api.sig_appinfo');
                    break;
                }
                case 'signup': {
                    $str_hash = Config::get('api.sig_signup');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'signin': {
                    $str_hash = Config::get('api.sig_signin');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'menu': {
                    $str_hash = Config::get('api.sig_menu');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'items': {
                    $str_hash = Config::get('api.sig_items');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'news': {
                    $str_hash = Config::get('api.sig_news');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'photo_cat': {
                    $str_hash = Config::get('api.sig_photo_cat');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'photo': {
                    $str_hash = Config::get('api.sig_photo');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'reserve': {
                    $str_hash = Config::get('api.sig_reserve');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'coupon': {
                    $str_hash = Config::get('api.sig_coupon');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'sig_staff_category': {
                    $str_hash = Config::get('api.sig_staff_category');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                case 'sig_staffs': {
                    $str_hash = Config::get('api.sig_staffs');
                    $str_param = $this->validate_param_test($str_hash);
                    $str_sig = $this->get_sig($str_hash, $secret_key, $time);
                    break;
                }
                default:
                    break;
            }
            $str_hash[] = 'secret_key';
            $message = '';
            if (!$str_param)
                $message = 'Miss param hash,note: don\'t need param time';
            $arr = ['time' => $time, 'sig' => $str_sig, 'hash' => $str_hash, 'message' => $message];

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data'] = $arr;
        return $this->output($this->body);
    }

    public function list_app()
    {
        try {
            $arr = $this->_topRepository->get_app_info_from_token(123456);
            
            $arr = $this->_topRepository->list_app();


        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data'] = $arr;
        return $this->output($this->body);
    }

    public function notification(Request $request)
    {
        $check_items = array('app_user_id', 'type','created_by');//Config::get('api.items_notification');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
//        $check_items = Config::get('api.sig_notification');
//        //validate sig
//        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
//        if ($ret_sig)
//            return $ret_sig;
        try
        {
            Redis::publish(Config::get('api.redis_chanel_notification'), json_encode(Input::all()));
//            $process = new NotificationRepository();
//            $process->process_notify(json_encode(Input::all()));
        }
        catch (PredisException $e)
        {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
        return $this->output($this->body);
    }

    public function notification_with_app_id(Request $request)
    {
        $check_items = array('app_id', 'type','created_by');//Config::get('api.items_notification');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
//        $check_items = Config::get('api.sig_notification');
//        //validate sig
//        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
//        if ($ret_sig)
//            return $ret_sig;
        try
        {
            Redis::publish(Config::get('api.redis_chanel_notification'), json_encode(Input::all()));
//            $process = new NotificationRepository();
//            $process->process_notify(json_encode(Input::all()));
        }
        catch (PredisException $e)
        {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
        return $this->output($this->body);
    }
}
