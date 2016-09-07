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
use App\Models\News;
use App\Models\UserPushLogTracking;
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
                        ),
                            "app" => array(
                                "android_push_service_file" => $rsApp[0]['android_push_service_file'],
                                "android_push_api_key" => $rsApp[0]['android_push_api_key'],
                                "apple_push_cer_file" => $rsApp[0]['apple_push_cer_file'],
                                "apple_push_cer_password" => $rsApp[0]['apple_push_cer_password']
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
        if (count($rs) > 0) {
            $isPerNoti = $this->check_permission_notify_from_data($rs['userpushs'], $type);
            if ($isPerNoti) {
                return array("android_push_key" => $rs['user']['android_push_key'],
                    "apple_push_key" => $rs['user']['apple_push_key'],
                    "android_push_service_file" => $rs['app']['android_push_service_file'],
                    "android_push_api_key" => $rs['app']['android_push_api_key'],
                    "apple_push_cer_file" => $rs['app']['apple_push_cer_file'],
                    "apple_push_cer_password" => $rs['app']['apple_push_cer_password']);
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

    public function process_notify($message)
    {
//        $message = '
//{
//  "app_user_id":1,
//  "type":"news",
//  "data_id":1,
//  "data_value":"",
//  "created_by":"bangnk"
//}';
        if (!empty($message)) {
            $obj = json_decode($message);
            if (count($obj) > 0) {
                if (property_exists($obj, "app_user_id") && property_exists($obj, "type")) {
                    $notify_info = $this->get_info_nofication($obj->app_user_id, $obj->type);

                    $data_notify = null;
                    if (count($notify_info) > 0) {
                        switch ($obj->type) {
                            case "news":
                                $news = News::where('id', $obj->data_id)->get()->toArray();
                                if (count($news) > 0) {
                                    $data_notify = array('title' => $news[0]['title'],
                                        'desc' => $news[0]['description'],
                                        'subtitle' => '',
                                        'tickertext' => '');
                                }
                                break;
                            case "ranking":
                                break;
                            case "coupon":
                                break;
                            case "chat":
                                break;
                            case "custom":
                                if (!empty($obj->data_value))
                                {
                                    $data_notify = array('title' => $obj->data_value,
                                        'desc' => $obj->data_value,
                                        'subtitle' => '',
                                        'tickertext' => '');
                                }
                                break;
                            default:
                                break;
                        }
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
                                if ($rs_android)
                                    $obj->notify_status = 1;//success
                                else
                                    $obj->notify_status = 0;//fail
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
}