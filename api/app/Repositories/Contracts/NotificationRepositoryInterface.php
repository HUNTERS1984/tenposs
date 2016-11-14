<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/5/16
 * Time: 9:48 AM
 */

namespace App\Repositories\Contracts;


interface NotificationRepositoryInterface
{
    public function get_app_push_from_app_id($app_id);

    public function check_permission_notify($app_id, $type); //type:ranking,news,coupon,chat,custom

    public function check_permission_notify_from_data($data, $type); //type:ranking,news,coupon,chat,custom

    public function get_info_nofication($app_id, $type); //type:ranking,news,coupon,chat,custom

    public function process_notify($message, $app_user_id);

    public function receive_and_distribute($message);

    public function staffs_get_push_info_from_apps($app_app_id, $staff_id);

    public function staffs_get_nofication($app_id, $staff_id, $type);

    public function staffs_process_notify($message);

}