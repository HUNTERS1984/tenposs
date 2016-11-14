<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/5/16
 * Time: 1:06 PM
 */

namespace App\Repositories\Eloquents;


use App\Models\Apps;
use App\Models\AppUser;
use App\Models\Coupon;
use App\Models\News;
use App\Models\Staff;
use App\Models\UserPushLogTracking;
use App\Models\WebPushCurrent;
use App\Repositories\Contracts\NotificationRepositoryInterface;

use App\Utils\PushNotification;
use App\Utils\RedisUtil;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Predis\PredisException;

class NotificationRepository implements NotificationRepositoryInterface
{

    public function get_app_push_from_app_id($app_user_id)
    {
        try {
            if ($app_user_id > 0) {
                //create key redis
//                $key = sprintf(Config::get('api.cache_app_user_push'), $app_id);
////        //get data from redis
//                $rs = RedisUtil::getInstance()->get_cache($key);
//                //check data and return data
//                if ($rs != null) {
//                    return $rs;
//                }
                $result = null;
                $rs = AppUser::with('userpushs')->where('id', $app_user_id)->get()->toArray();
                if (count($rs) > 0) {
                    $app_id = $rs[0]['app_id'];

                    $rsApp = Apps::where('id', $app_id)->get()->toArray();
                    if (count($rsApp) > 0) {
                        $result = array("user" => array(
                            "android_push_key" => $rs[0]['android_push_key'],
                            "apple_push_key" => $rs[0]['apple_push_key'],
                            "web_user_push_key" => $rs[0]['web_push_key'],
                        ),
                            "app" => array(
                                "android_push_service_file" => $rsApp[0]['android_push_service_file'],
                                "android_push_api_key" => $rsApp[0]['android_push_api_key'],
                                "apple_push_cer_file" => $rsApp[0]['apple_push_cer_file'],
                                "apple_push_cer_password" => $rsApp[0]['apple_push_cer_password'],
                                "web_push_server_key" => $rsApp[0]['web_push_server_key'],
                                "web_push_sender_id" => $rsApp[0]['web_push_sender_id']
                            ),
                            "userpushs" => $rs[0]['userpushs']);

                    }
                }
//                if ($rs != null && count($rs) > 0)//set cache redis
//                    RedisUtil::getInstance()->set_cache($key, $rs);
                return $result;
            }
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        } catch (PredisException $e) {
            Log::error($e->getMessage());
        }
        return null;
    }

    public function check_permission_notify($app_id, $type)
    {
        $isValid = false;
        if ($app_id > 0 && !empty($type)) {
            $rs = $this->get_app_push_from_app_id($app_id);

            if (count($rs) > 0 && array_key_exists('userpushs', $rs[0])) {
                $data = $rs[0]['userpushs'];
                if (count($data) > 0) {
                    if (array_key_exists($type, $data[0]) && $data[0][$type] == 1)
                        $isValid = true;
                }
            }
        }
        return $isValid;
    }

    public function get_info_nofication($app_id, $type)
    {
        $rs = $this->get_app_push_from_app_id($app_id);
        Log::info("get_app_push_from_app_id: " . json_encode($rs));
        if (count($rs) > 0) {
            $isPerNoti = $this->check_permission_notify_from_data($rs['userpushs'], $type);
            Log::info("check_permission_notify_from_data: " . json_encode($rs));
            if ($isPerNoti) {
                return array("android_push_key" => $rs['user']['android_push_key'],
                    "apple_push_key" => $rs['user']['apple_push_key'],
                    "android_push_service_file" => $rs['app']['android_push_service_file'],
                    "android_push_api_key" => $rs['app']['android_push_api_key'],
                    "apple_push_cer_file" => $rs['app']['apple_push_cer_file'],
                    "apple_push_cer_password" => $rs['app']['apple_push_cer_password'],
                    "web_push_server_key" => $rs['app']['web_push_server_key'],
                    "web_push_sender_id" => $rs['app']['web_push_sender_id'],
                    "web_user_push_key" => $rs['user']['web_user_push_key']);
            }
        }
        return null;
    }

    public function check_permission_notify_from_data($data, $type)
    {
        $isValid = false;
//        if (count($data) > 0 && array_key_exists('userpushs', $data[0]) && !empty($type)) {
//            $data = $data[0]['userpushs'];

        if (count($data) > 0) {
            if (array_key_exists($type, $data[0]) && $data[0][$type] == 1)
                $isValid = true;
        }
//        }
        return $isValid;
    }

    public function process_notify($message, $app_user_id)
    {
        if (!empty($message)) {
            $obj = json_decode($message);
            if (count($obj) > 0) {
                if ($app_user_id > 0)
                    $obj->app_user_id = $app_user_id;
                if (property_exists($obj, "app_user_id") && property_exists($obj, "type")) {

                    $notify_info = $this->get_info_nofication($obj->app_user_id, $obj->type);
                    Log::info("get_info_nofication: " . json_encode($notify_info));
                    $data_notify = null;
                    if (count($notify_info) > 0) {
                        switch ($obj->type) {
                            case "news":
                                $news = News::where('id', $obj->data_id)->get()->toArray();
                                if (count($news) > 0) {
                                    $data_notify = array('title' => $news[0]['title'],
                                        'desc' => $news[0]['description'],
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => $news[0]['id'],
                                        'type' => 'news',
                                        'image_url' => $news[0]['image_url']);
                                }
                                break;
                            case "ranking":
                                break;
                            case "coupon":
                                $coupons = Coupon::where('id', $obj->data_id)->get()->toArray();
                                if (count($coupons) > 0) {
                                    $data_notify = array('title' => $coupons[0]['title'],
                                        'desc' => $coupons[0]['description'],
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => $coupons[0]['id'],
                                        'type' => 'coupon',
                                        'image_url' => $coupons[0]['image_url']);
                                }
                                break;
                            case "chat":
                                if (!empty($obj->data_value)) {
                                    $data_notify = array('title' => $obj->title,
                                        'desc' => $obj->data_value,
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => 0,
                                        'type' => 'chat',
                                        'image_url' => '');
                                }
                                break;
                            case "custom":
                                if (!empty($obj->data_value)) {
                                    $data_notify = array('title' => $obj->title,
                                        'desc' => $obj->data_value,
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => 0,
                                        'type' => 'custom',
                                        'image_url' => '');
                                }
                                break;
                            default:
                                break;
                        }
                        Log::info("data_notify: " . json_encode($data_notify));
                        //process notify
                        if (count($data_notify) > 0) {
                            if (!empty($notify_info['android_push_key']) && !empty($notify_info['android_push_api_key'])) {
                                //notification to google
                                $rs_android = PushNotification::getInstance()->android($data_notify, $notify_info['android_push_key'], $notify_info['android_push_api_key']);
                                $obj->platform = 'android';
                                if ($rs_android)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                $this->save_log_tracking($obj);
                            }
//                            else {
//                                $obj->platform = 'android';
//                                $obj->notify_status = -1;//miss info
//                            }

                            if (!empty($notify_info['apple_push_key'] && !empty($notify_info['apple_push_cer_file'] && !empty($notify_info['apple_push_cer_password'])))) {
                                //notification to apple
                                $rs_ios = PushNotification::getInstance()->iOS($data_notify, $notify_info['apple_push_key'], base_path() . $notify_info['apple_push_cer_file'], $notify_info['apple_push_cer_password']);
                                $obj->platform = 'ios';
                                if ($rs_ios)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                $this->save_log_tracking($obj);
                            }

                            if (!empty($notify_info['web_push_server_key'] && !empty($notify_info['web_user_push_key']))) {
                                //notification to apple
                                $rs_ios = PushNotification::getInstance()->web($data_notify, $notify_info['web_user_push_key'], $notify_info['web_push_server_key']);
                                $obj->platform = 'ios';
                                if ($rs_ios)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                //luu info cho web push
                                $web_push = new WebPushCurrent();
                                $web_push->key = $notify_info['web_user_push_key'];
                                $web_push->type = $obj->type;
                                $web_push->data_id = $data_notify['id'];
                                $web_push->data_value = $data_notify['desc'];
                                $web_push->title = $data_notify['title'];
                                $web_push->app_user_id = $obj->app_user_id;
                                $web_push->save();

                                $this->save_log_tracking($obj);
                            }


//                            else {
//                                $obj->platform = 'ios';
//                                $obj->notify_status = -1;//miss info
//                            }

                        }
                    }
                }
            }
        }
    }

    public function process_notify_staffs($message, $staff_id)
    {
        if (!empty($message)) {
            $obj = json_decode($message);
            if (count($obj) > 0) {
                if (property_exists($obj, "staff_id") && property_exists($obj, "type")) {

                    $notify_info = $this->get_info_nofication($obj->app_user_id, $obj->type);
                    Log::info("get_info_nofication: " . json_encode($notify_info));
                    $data_notify = null;
                    if (count($notify_info) > 0) {
                        switch ($obj->type) {
                            case "news":
                                $news = News::where('id', $obj->data_id)->get()->toArray();
                                if (count($news) > 0) {
                                    $data_notify = array('title' => $news[0]['title'],
                                        'desc' => $news[0]['description'],
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => $news[0]['id'],
                                        'type' => 'news',
                                        'image_url' => $news[0]['image_url']);
                                }
                                break;
                            case "ranking":
                                break;
                            case "coupon":
                                $coupons = Coupon::where('id', $obj->data_id)->get()->toArray();
                                if (count($coupons) > 0) {
                                    $data_notify = array('title' => $coupons[0]['title'],
                                        'desc' => $coupons[0]['description'],
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => $coupons[0]['id'],
                                        'type' => 'coupon',
                                        'image_url' => $coupons[0]['image_url']);
                                }
                                break;
                            case "chat":
                                if (!empty($obj->data_value)) {
                                    $data_notify = array('title' => $obj->title,
                                        'desc' => $obj->data_value,
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => 0,
                                        'type' => 'chat',
                                        'image_url' => '');
                                }
                                break;
                            case "custom":
                                if (!empty($obj->data_value)) {
                                    $data_notify = array('title' => $obj->title,
                                        'desc' => $obj->data_value,
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'id' => 0,
                                        'type' => 'custom',
                                        'image_url' => '');
                                }
                                break;
                            default:
                                break;
                        }
                        Log::info("data_notify: " . json_encode($data_notify));
                        //process notify
                        if (count($data_notify) > 0) {
                            if (!empty($notify_info['android_push_key']) && !empty($notify_info['android_push_api_key'])) {
                                //notification to google
                                $rs_android = PushNotification::getInstance()->android($data_notify, $notify_info['android_push_key'], $notify_info['android_push_api_key']);
                                $obj->platform = 'android';
                                if ($rs_android)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                $this->save_log_tracking($obj);
                            }
//                            else {
//                                $obj->platform = 'android';
//                                $obj->notify_status = -1;//miss info
//                            }

                            if (!empty($notify_info['apple_push_key'] && !empty($notify_info['apple_push_cer_file'] && !empty($notify_info['apple_push_cer_password'])))) {
                                //notification to apple
                                $rs_ios = PushNotification::getInstance()->iOS($data_notify, $notify_info['apple_push_key'], base_path() . $notify_info['apple_push_cer_file'], $notify_info['apple_push_cer_password']);
                                $obj->platform = 'ios';
                                if ($rs_ios)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                $this->save_log_tracking($obj);
                            }

                            if (!empty($notify_info['web_push_server_key'] && !empty($notify_info['web_user_push_key']))) {
                                //notification to apple
                                $rs_ios = PushNotification::getInstance()->web($data_notify, $notify_info['web_user_push_key'], $notify_info['web_push_server_key']);
                                $obj->platform = 'ios';
                                if ($rs_ios)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                //luu info cho web push
                                $web_push = new WebPushCurrent();
                                $web_push->key = $notify_info['web_user_push_key'];
                                $web_push->type = $obj->type;
                                $web_push->data_id = $data_notify['id'];
                                $web_push->data_value = $data_notify['desc'];
                                $web_push->title = $data_notify['title'];
                                $web_push->app_user_id = $obj->app_user_id;
                                $web_push->save();

                                $this->save_log_tracking($obj);
                            }


//                            else {
//                                $obj->platform = 'ios';
//                                $obj->notify_status = -1;//miss info
//                            }

                        }
                    }
                }
            }
        }
    }

    private function save_log_tracking($data)
    {
        try {
            $log = new UserPushLogTracking();
            $log->type = $data->type;
            $log->data_id = $data->data_id;
            $log->data_value = $data->data_value;
            $log->platform = $data->platform;
            $log->created_by = $data->created_by;
            $log->created_at = date('Y-m-d H:i:s');
            $log->updated_at = date('Y-m-d H:i:s');
            $log->updated_by = $data->created_by;
            $log->notify_status = $data->notify_status;
            $log->app_user_id = $data->app_user_id;
            $log->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }
    }

    public function receive_and_distribute($message)
    {
        if (!empty($message)) {
            $obj = json_decode($message);
            if (count($obj) > 0) {
                if (property_exists($obj, "app_user_id") && $obj->app_user_id > 0) {
                    //process notification app_user_id
                    Log::info('send notify to one app_user_id: ' . $obj->app_user_id);
                    $this->process_notify($message, $obj->app_user_id);
                } else if (property_exists($obj, "app_id") && $obj->app_id > 0) { // //process notification app_id
                    Log::info('send notify to app_id: ' . $obj->app_id);
                    $app_user_info = AppUser::where('app_id', $obj->app_id)->get()->toArray();
                    if (count($app_user_info) > 0) { //send notify to app_user_id
                        foreach ($app_user_info as $item) {
                            Log::info('send notify to  user: ' . $item['email']);
                            $this->process_notify($message, $item['id']);
                        }
                    }
                } else if (property_exists($obj, "staff_id") && $obj->staffs_id > 0) // process notification for staffs
                {

                } else {
                    Log::info('message invalid: ' + $message);
                }
            }
        }
    }

    public function staffs_get_push_info_from_apps($app_app_id, $staff_id)
    {
        try {
            if ($staff_id > 0) {
                $result = null;
                $rs = Staff::where('id', $staff_id)->get()->toArray();
                if (count($rs) > 0) {
                    $rsApp = Apps::where('app_app_id', $app_app_id)->get()->toArray();
                    if (count($rsApp) > 0) {
                        $result = array("user" => array(
                            "android_push_key" => $rs[0]['android_push_key'],
                            "apple_push_key" => $rs[0]['apple_push_key'],
//                            "web_user_push_key" => $rs[0]['web_push_key'],
                        ),
                            "app" => array(
                                "android_push_service_file" => $rsApp[0]['android_push_service_file'],
                                "android_push_api_key" => $rsApp[0]['android_push_api_key'],
                                "apple_push_cer_file" => $rsApp[0]['apple_push_cer_file'],
                                "apple_push_cer_password" => $rsApp[0]['apple_push_cer_password'],
                                "web_push_server_key" => $rsApp[0]['web_push_server_key'],
                                "web_push_sender_id" => $rsApp[0]['web_push_sender_id']
                            ));

                    }
                }
                return $result;
            }
        } catch (QueryException $ex) {
            Log::error($ex->getMessage());
        } catch (PredisException $e) {
            Log::error($e->getMessage());
        }
        return null;
    }

    public function staffs_get_nofication($app_app_id, $staff_id, $type)
    {
        $rs = $this->staffs_get_push_info_from_apps($app_app_id, $staff_id);
        Log::info("staffs_get_nofication: " . json_encode($rs));
        if (count($rs) > 0) {
            return array("android_push_key" => $rs['user']['android_push_key'],
                "apple_push_key" => $rs['user']['apple_push_key'],
                "android_push_service_file" => $rs['app']['android_push_service_file'],
                "android_push_api_key" => $rs['app']['android_push_api_key'],
                "apple_push_cer_file" => $rs['app']['apple_push_cer_file'],
                "apple_push_cer_password" => $rs['app']['apple_push_cer_password'],
                "web_push_server_key" => $rs['app']['web_push_server_key'],
                "web_push_sender_id" => $rs['app']['web_push_sender_id']);
//                "web_user_push_key" => $rs['user']['web_user_push_key']);
        }
        return null;
    }

    public function staffs_process_notify($message)
    {
        if (!empty($message)) {
            $obj = json_decode($message);
            if (count($obj) > 0) {
                if (property_exists($obj, "app_app_id") && property_exists($obj, "type")
                    && property_exists($obj, "staff_id")
                ) {
                    $notify_info = $this->staffs_get_nofication($obj->app_app_id, $obj->staff_id, $obj->type);
                    Log::info("staffs_get_nofication: " . json_encode($notify_info));
                    $data_notify = null;
                    if (count($notify_info) > 0) {
                        switch ($obj->type) {
                            case "staffs":
                                $items = Coupon::where('id', $obj->coupon_id)->get()->toArray();
                                if (count($items) > 0) {
                                    $data_notify = array('title' => $items[0]['title'],
                                        'desc' => $items[0]['description'],
                                        'subtitle' => '',
                                        'tickertext' => '',
                                        'coupon_id' => $items[0]['id'],
                                        'type' => 'staffs',
                                        'staff_id' => $obj->staff_id,
                                        'image_url' => UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $items[0]['image_url']));
                                }
                                break;
                            default:
                                break;
                        }
                        Log::info("data_notify: " . json_encode($data_notify));
                        //process notify
                        if (count($data_notify) > 0) {
                            if (!empty($notify_info['android_push_key']) && !empty($notify_info['android_push_api_key'])) {
                                //notification to google
                                $rs_android = PushNotification::getInstance()->android($data_notify, $notify_info['android_push_key'], $notify_info['android_push_api_key']);
                                $obj->platform = 'android';
                                if ($rs_android)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                $this->save_log_tracking($obj);
                            }

                            if (!empty($notify_info['apple_push_key'] && !empty($notify_info['apple_push_cer_file'] && !empty($notify_info['apple_push_cer_password'])))) {
                                //notification to apple
                                $rs_ios = PushNotification::getInstance()->iOS($data_notify, $notify_info['apple_push_key'], base_path() . $notify_info['apple_push_cer_file'], $notify_info['apple_push_cer_password']);
                                $obj->platform = 'ios';
                                if ($rs_ios)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
                                $this->save_log_tracking($obj);
                            }
                        }
                    }
                }
            }
        }
    }

}
