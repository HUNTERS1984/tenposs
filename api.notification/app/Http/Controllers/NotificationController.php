<?php

namespace App\Http\Controllers;

use App\AppSetting;
use App\UserPush;
use App\UserPushSetting;
use App\Utils\ConvertUtils;
use App\Utils\ProcessNotification;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use JWTAuth;
use Predis\Connection\ConnectionException;
use Symfony\Component\Process\Process;
use Tymon\JWTAuth\Exceptions\JWTException;
use DateTime;
use DateTimeZone;

class NotificationController extends Controller
{


    public function __construct()
    {

    }

    public function user_set_push_key()
    {
        $check_items = array('app_id', 'client', 'key');
        $ret = $this->validate_param($check_items);

        if ($ret)
            return $ret;
        $token = JWTAuth::getToken();
        $info = JWTAuth::decode($token)->toArray();
        if (count($info) > 0) {
            try {
                $user_pushes = UserPush::where('auth_user_id', $info['id'])
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('app_type', 'user')->first();
                if (count($user_pushes) < 1)
                    $user_pushes = new UserPush();
                $user_pushes->app_type = 'user';
                $user_pushes->app_app_id = Input::get('app_id');
                $user_pushes->auth_user_id = $info['id'];
                if (Input::get('client') == 'android')
                    $user_pushes->android_push_key = Input::get('key');
                else if (Input::get('client') == 'ios')
                    $user_pushes->apple_push_key = Input::get('key');
                else if (Input::get('client') == 'web')
                    $user_pushes->web_push_key = Input::get('key');
                $user_pushes->save();
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
            return $this->output($this->body);

        } else {
            return $this->error(9998);
        }
    }

    public function user_get_push_setting()
    {
        try {
            $app_id = Input::get('app_id');
            $token = JWTAuth::getToken();
            $info = JWTAuth::decode($token)->toArray();
            if (count($info) > 0) {
                try {
                    $user_setting = UserPushSetting::where('app_app_id', $app_id)
                        ->where('auth_user_id', $info['id'])
                        ->where('app_type', 'user')->first();
                    if (count($user_setting) > 0) {
                        $this->body['data'] = $user_setting;
                        return $this->output($this->body);
                    } else {
//                        return $this->error(99953);
                        $user_setting = new UserPushSetting();
                        $user_setting->ranking = 0;
                        $user_setting->news = 0;
                        $user_setting->coupon = 0;
                        $user_setting->chat = 0;
                        $user_setting->other = 0;
                        $user_setting->app_app_id = $app_id;
                        $user_setting->auth_user_id = $info['id'];
                        $user_setting->app_type = 'user';
                        $user_setting->save();
                        $this->body['data'] = $user_setting;
                        return $this->output($this->body);
                    }
                } catch (QueryException $e) {
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }
            } else
                return $this->error(9998);
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
    }

    public function user_set_push_setting()
    {
        $check_items = array('app_id', 'ranking', 'news', 'coupon', 'chat');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $token = JWTAuth::getToken();
        $info = JWTAuth::decode($token)->toArray();
        if (count($info) > 0) {
            try {
                $user_setting = UserPushSetting::where('app_app_id', Input::get('app_id'))
                    ->where('auth_user_id', $info['id'])
                    ->where('app_type', 'user')->first();
                if (count($user_setting) < 1)
                    $user_setting = new UserPushSetting();
                $user_setting->ranking = Input::get('ranking');
                $user_setting->news = Input::get('news');
                $user_setting->coupon = Input::get('coupon');
                $user_setting->chat = Input::get('chat');
                $user_setting->ranking = Input::get('ranking');
                $user_setting->other = 0;
                $user_setting->app_type = 'user';
                $user_setting->auth_user_id = $info['id'];
                $user_setting->app_app_id = Input::get('app_id');
                $user_setting->save();

            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
            return $this->output($this->body);
        } else
            return $this->error(9998);
    }

    public function user_notification()
    {

        $check_items = array();
        switch (Input::get('type')) {
            case 'news':
            case 'coupon':
            case 'ranking':
                $check_items = array('app_id', 'type', 'data_id');
                break;
            case 'custom':
            case 'chat':
                $check_items = array('app_id', 'type', 'title', 'message');
                break;
            default:
                $check_items = array('app_id', 'type');
                break;
        }
        if (count($check_items) < 1)
            return $this->error(1002);
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $is_notify_now = false;
        $notification_time = '';
        if (!empty(Input::get('notification_time'))) {
            $now_time = Carbon::now()->setTimezone('UTC')->timestamp;
            $input_time = Carbon::createFromFormat("Y/m/d H:i:s", Input::get('notification_time'))
                ->setTimezone('UTC');
            $notification_time = $input_time->toDateTimeString();

            $input_time = $input_time->timestamp;
            $compare_time = $input_time - $now_time;
            if ($compare_time < 60) // smaller 60s, notification now
                $is_notify_now = true;
            else
                $is_notify_now = false;
        } else { //time input empty, notification now
            $is_notify_now = true;
        }
        try {
            $token = JWTAuth::getToken();
            $info = JWTAuth::decode($token)->toArray();
            if (count($info) > 0) {
                try {
                    $data = Input::all();
                    $data['auth_user_id'] = $info['id'];
                    if (!array_key_exists('all_user', $data))
                        $data['all_user'] = 0;
                    $data['user_type'] = "user";
                    $data['notification_time'] = $notification_time;

                    if ($is_notify_now)
                        Redis::publish(Config::get('api.redis_chanel_notification'), json_encode($data));
                    else { //insert to temp table
                        $data['app_app_id'] = $data['app_id'];
                        unset($data['app_id']);
                        $data['created_at'] = Carbon::now();
                        $data['updated_at'] = Carbon::now();
                        \Illuminate\Support\Facades\DB::table('waiting_notification')
                            ->insert($data);
                    }

                } catch (ConnectionException $e) {
                    Log::error($e->getMessage());
                    return $this->error(9999);
                } catch (PredisException $e) {
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }
                return $this->output($this->body);
            } else
                return $this->error(9998);
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return $this->error(9998);
        }
        return $this->output($this->body);
    }

    public function staff_set_push_key()
    {
        $check_items = array('app_id', 'client', 'key');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $token = JWTAuth::getToken();
        $info = JWTAuth::decode($token)->toArray();
        if (count($info) > 0) {
            try {
                $user_pushes = UserPush::where('auth_user_id', $info['id'])
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('app_type', 'staff')->first();
                if (count($user_pushes) < 1)
                    $user_pushes = new UserPush();
                $user_pushes->app_type = 'staff';
                $user_pushes->app_app_id = Input::get('app_id');
                $user_pushes->auth_user_id = $info['id'];
                if (Input::get('client') == 'android')
                    $user_pushes->android_push_key = Input::get('key');
                else if (Input::get('client') == 'ios')
                    $user_pushes->apple_push_key = Input::get('key');
                else if (Input::get('client') == 'web')
                    $user_pushes->web_push_key = Input::get('key');
                $user_pushes->save();
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
            return $this->output($this->body);
        } else {
            return $this->error(9998);
        }

    }

    public function staff_notification()
    {
        $check_items = array('app_id', 'type', 'notification_to');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        try {
            $token = JWTAuth::getToken();
            $info = JWTAuth::decode($token)->toArray();
            if (count($info) > 0) {
                try {
                    $data = Input::all();
                    $data['auth_user_id'] = $info['id'];
                    $data['user_type'] = "staff";
                    Redis::publish(Config::get('api.redis_chanel_notification'), json_encode($data));
                } catch (ConnectionException $e) {
                    Log::error($e->getMessage());
                    return $this->error(9999);
                } catch (PredisException $e) {
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }
                return $this->output($this->body);
            } else
                return $this->error(9998);
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return $this->error(9998);
        }
        return $this->output($this->body);
    }

    public function configure_notification()
    {
        //android,ios: api_key, file
        //web: api_key,sender_id
        $platform = 0;
        $check_items = array();
        switch (Input::get('platform')) {
            case 'android':
                $check_items = array('platform', 'app_id', 'push_key');
                $platform = 1;
                break;
            case 'android_staff':
                $check_items = array('platform', 'app_id', 'push_key');
                $platform = 4;
                break;
            case 'ios':
                $check_items = array('platform', 'app_id', 'push_key');
                $platform = 2;
                break;
            case 'ios_staff':
                $check_items = array('platform', 'app_id', 'push_key');
                $platform = 5;
                break;
            case 'web':
                $check_items = array('platform', 'app_id', 'push_key', 'sender_id');
                $platform = 3;
                break;
            case 'ga':
                $check_items = array('platform', 'app_id');
                $platform = 6;
                break;
            default:
                break;
        }
        if (count($check_items) < 1)
            return $this->error(1002);
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        try {
            $token = JWTAuth::getToken();
            $info = JWTAuth::decode($token)->toArray();
            if (count($info) > 0) {
                try {
                    $app_setting = AppSetting::where('app_app_id', Input::get('app_id'))->first();
                    if (count($app_setting) < 1)
                        $app_setting = new AppSetting();
                    $app_setting->app_app_id = Input::get('app_id');
                    $path_file = '';
                    if (Input::file('push_file') != null && Input::file('push_file')->isValid()) {
                        $destinationPath = 'uploads'; // upload path
                        $extension = Input::file('push_file')->getClientOriginalExtension(); // getting image extension
                        $fileName = Input::get('app_id') . '_' . md5(Input::file('push_file')->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
                        Input::file('push_file')->move($destinationPath, $fileName); // uploading file to given path

                        if ($platform == 1 || $platform == 4)
                            $path_file = $destinationPath . '/' . $fileName;
                        else if ($platform == 2 || $platform == 5) {
                            $path_file_relative = $destinationPath . '/' . $fileName;
                            $desPath = '/public/' . $destinationPath . '/';

                            if ($extension == 'p12')
                                $path_file = ConvertUtils::convert_p12_to_pem($path_file_relative, Input::get('push_key'), $desPath, Input::get('app_id'));
                            if (!empty($path_file))
                                $path_file = $destinationPath . '/' . $path_file;
                        }
                    }
                    if ($platform == 1) {
                        $app_setting->android_push_api_key = Input::get('push_key');
                        $app_setting->android_push_service_file = $path_file;
                    } else if ($platform == 2) {
                        $app_setting->apple_push_cer_password = Input::get('push_key');
                        $app_setting->apple_push_cer_file = $path_file;
                    } else if ($platform == 3) {
                        $app_setting->web_push_server_key = Input::get('push_key');
                        $app_setting->web_push_sender_id = Input::get('sender_id');
                    } else if ($platform == 4) {
                        $app_setting->staff_android_push_api_key = Input::get('push_key');
                        $app_setting->staff_android_push_service_file = $path_file;
                    } else if ($platform == 5) {
                        $app_setting->staff_apple_push_cer_password = Input::get('push_key');
                        $app_setting->staff_apple_push_cer_file = $path_file;
                    } else if ($platform == 6) {
                        $app_setting->google_analytics_file = $path_file;
                    }
                    $app_setting->save();
                    return $this->output($this->body);
                } catch (QueryException $e) {
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }
            } else
                return $this->error(9998);
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
    }

    public function get_configure_notification($app_id)
    {
        if ($app_id < 1)
            return $this->error(1002);
        try {
            $data = \Illuminate\Support\Facades\DB::table('apps_setting')->where('app_app_id', '=', $app_id)->get();
            $this->body['data'] = $data;
            return $this->output($this->body);

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            print_r($e->getMessage());
            die;
            return $this->error(9999);
        }
    }

    public function test()
    {
//        print_r(base_path('public'));
//        $data = ProcessNotification::getInstance()->get_data_from_id_with_api('coupon', 192, '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
//        print_r($data);
        $message = '{"app_id":"2a33ba4ea5c9d70f9eb22903ad1fb8b2","type":"news","notification_to":13,"data_id":40,"auth_user_id":13,"all_user":0,"user_type":"user","notification_time":""}';
        ProcessNotification::getInstance()->process($message);
        die;
    }

}