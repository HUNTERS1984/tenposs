<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 11/13/16
 * Time: 9:47 PM
 */

namespace App\Utils;


use App\AppSetting;
use App\UserPush;
use App\UserPushSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProcessNotification
{
    protected static $_instance = null;

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function process($message)
    {
        if (!empty($message)) {
            $obj = json_decode($message);

            if (count($obj) > 0) {
                if (property_exists($obj, "user_type")) {
                    switch ($obj->user_type) {
                        case 'user': //process user
                            $this->process_user($obj);
                            break;
                        case 'staff': //process staff
                            $this->process_staff($obj);
                            break;
                    }
                }
            }
        }
    }

    private function process_user($obj)
    {

        if (property_exists($obj, 'app_id')) {
            if (property_exists($obj, "all_user") && $obj->all_user == 1) {
                //notification to all user on app
            } else {
                //notification to one user
                if (property_exists($obj, 'notification_to')) {
                    $data_id = 0;
                    if (property_exists($obj, 'data_id'))
                        $data_id = $obj->data_id;
                    $tile = 0;
                    if (property_exists($obj, 'title'))
                        $tile = $obj->title;
                    $message = 0;
                    if (property_exists($obj, 'message'))
                        $message = $obj->message;
                    $auth_user_id = 0;
                    if (property_exists($obj, 'auth_user_id'))
                        $auth_user_id = $obj->auth_user_id;

                    $this->notification_to_one_user($obj->app_id,$auth_user_id, $obj->notification_to, $obj->type, $obj->user_type, $data_id, $tile, $message);
                }
            }
        }
    }

    private function notification_to_one_user($app_id,$auth_user_id, $notification_to, $type, $user_type = '', $data_id = 0, $tile = '', $message = '')
    {
        if ($this->check_permission_notify_from_data($app_id,$auth_user_id, $notification_to, $type)) { // user allow notification

            $app_setting = $this->get_notification_setting($app_id);
            $user_setting = $this->get_user_setting($app_id, $notification_to, $user_type);
            Log::info("get_notification_setting: ".json_encode($app_setting));
            Log::info("get_user_setting:".json_encode($user_setting));
            if ($app_setting != null && count($app_setting) > 0 && $user_setting != null && count($user_setting) > 0) {
                $data_notify = array();
                switch ($type) {
                    case 'custom':
                        if (!empty($message)) {
                            $data_notify = array('title' => $tile,
                                'desc' => $message,
                                'subtitle' => '',
                                'tickertext' => '',
                                'id' => 0,
                                'type' => 'custom',
                                'image_url' => '');
                        }
                        break;
                    case 'news':
                        $data = $this->get_data_from_id_with_api('news', $data_id, $app_id);
                        Log::info("data_news: ". json_encode($data));
                        if ($data != null && count($data) > 0) {
                            $data_notify = array('title' => $data->title,
                                'desc' => '',
                                'subtitle' => '',
                                'tickertext' => '',
                                'id' => $data->id,
                                'type' => 'news',
                                'image_url' => $data->image_url);
                        }
                        break;
                    case 'coupon':
                        $data = $this->get_data_from_id_with_api('coupon', $data_id, $app_id);
                        if ($data != null && count($data) > 0) {
                            $data_notify = array('title' => $data->title,
                                'desc' => '',//$data->description,
                                'subtitle' => '',
                                'tickertext' => '',
                                'id' => $data->id,
                                'type' => 'coupon',
                                'image_url' => $data->image_url);
                        }
                        break;
                }
                if (count($data_notify) > 0) {
                    Log::info("data_notify: ".json_encode($data_notify));
                    $this->send_message_to_user($app_setting, $user_setting, $data_notify);
                }
                else
                    Log::info("data send empty");
            }
        }
    }

    public function get_data_from_id_with_api($type, $data_id, $app_id)
    {
        $app_info = HttpRequestUtil::getInstance()->get_data('app_secret_info', array('app_id' => $app_id));
        if ($app_info != null && !empty($app_info)) {
            $obj_app_info = json_decode($app_info);
            if ($obj_app_info != null && count($obj_app_info) > 0) {
//                print_r($obj_app_info);
                if ($obj_app_info->code == 1000) {
                    $dataResult = null;
                    switch ($type) {
                        case 'news':
                            $tmp = HttpRequestUtil::getInstance()->get_data('news_detail',
                                array('app_id' => $app_id, 'id' => $data_id), $obj_app_info->data->app_app_secret);
                            if ($tmp != null && !empty($tmp)) {
                                $tmp_obj = json_decode($tmp);
                                if ($tmp_obj != null && count($tmp_obj) > 0 && $tmp_obj->code == 1000) {
                                    $dataResult = $tmp_obj->data->news;
                                }
                            }
                            break;
                        case 'coupon':
                            $tmp = HttpRequestUtil::getInstance()->get_data('coupon_detail',
                                array('app_id' => $app_id, 'id' => $data_id), $obj_app_info->data->app_app_secret);
                            if ($tmp != null && !empty($tmp)) {
                                $tmp_obj = json_decode($tmp);
                                if ($tmp_obj != null && count($tmp_obj) > 0 && $tmp_obj->code == 1000) {
                                    $dataResult = $tmp_obj->data->coupons;
                                }
                            }
                            break;
                        default:
                            break;
                    }
                    return $dataResult;
                }
            }
        }
        return null;
    }

    private function send_message_to_user($app_setting, $user_setting, $data_notify)
    {
        //process notify
        if (count($data_notify) > 0) {
            if (!empty($user_setting['android_push_key']) && !empty($app_setting['android_push_api_key'])) {
                //notification to google
                $rs_android = PushNotification::getInstance()->android($data_notify, $user_setting['android_push_key'], $app_setting['android_push_api_key']);
            }
            if (!empty($user_setting['apple_push_key'] && !empty($app_setting['apple_push_cer_file'] && !empty($app_setting['apple_push_cer_password'])))) {
                //notification to apple
                $rs_ios = PushNotification::getInstance()->iOS($data_notify, $user_setting['apple_push_key'], base_path('public/') . $app_setting['apple_push_cer_file'], $app_setting['apple_push_cer_password']);
            }
            if (!empty($app_setting['web_push_server_key'] && !empty($user_setting['web_push_key']))) {
                //notification to apple
                $rs_ios = PushNotification::getInstance()->web($data_notify, $user_setting['web_push_key'], $app_setting['web_push_server_key']);
            }
        }
    }

    private function process_staff($obj)
    {


    }


    private function get_notification_setting($app_id)
    {
        try {
            $data = AppSetting::where('app_app_id', $app_id)->first();
            if ($data)
                return $data->toArray();
        } catch (QueryException $e) {
            Log::error($e);
        }
        return null;
    }

    private function get_user_setting($app_id, $user_id, $app_type)
    {
        try {
            $data = UserPush::where('app_app_id', $app_id)
                ->where('app_type', $app_type)
                ->where('auth_user_id', $user_id)->first();
            if ($data)
                return $data->toArray();
        } catch (QueryException $e) {
            Log::error($e);
        }
        return null;
    }

    private function get_permission_setting_user($app_id, $notification_to)
    {
        try {
            return UserPushSetting::where('app_app_id', $app_id)
                ->where('auth_user_id', $notification_to)->get();
        } catch (QueryException $e) {
            Log::error($e);
        }
        return null;
    }

    public function check_permission_notify_from_data($app_id, $auth_user_id,$notification_to, $type)
    {
        if ($type == 'custom')
            return true;
        $isValid = false;
        $data = $this->get_permission_setting_user($app_id, $notification_to);
        Log::info("get_permission_setting_user:" . $data);
        Log::info("app_id:" . $app_id);
        Log::info("notification_to:" . $notification_to);
        if (count($data) > 0) {
            $data_check = $data->toArray();
            Log::info("data_check:" . json_encode($data_check));
            Log::info("type:" . $type);

            if (array_key_exists($type, $data_check[0]) && $data_check[0][$type] == 1)
                $isValid = true;

        }
        Log::info("isValid".$isValid);
        return $isValid;
    }
}