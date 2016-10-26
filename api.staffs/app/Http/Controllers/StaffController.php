<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/23/16
 * Time: 5:02 PM
 */

namespace App\Http\Controllers;


use App\Utils\UrlHelper;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class StaffController extends Controller
{
    public function set_push_key()
    {
        $check_items = Config::get('api.key_set_push_key');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $arr_data = array();
        if (Input::get('client') == 0)
            $arr_data = array('android_push_key' => Input::get('key'));
        else if (Input::get('client') == 3)
            $arr_data = array('web_push_key' => Input::get('key'));
        else
            $arr_data = array('apple_push_key' => Input::get('key'));
        if (count($arr_data) > 0) {
            try {
                $data_token = JWTAuth::parseToken()->getPayload();
                if (array_key_exists('staff_id', $data_token->get('data')))
                    DB::table('staffs')->where('id', $data_token->get('data')['staff_id'])->update($arr_data);
                else
                    return $this->error(1019);
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        }
        return $this->output($this->body);
    }

    public function coupon_accept()
    {
        $check_items = Config::get('api.key_coupon_accept');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $status = 0;
        if (strtolower(Input::get('action')) == 'approve')
            $status = 3;
        else if (strtolower(Input::get('action')) == 'reject')
            $status = 4;
        else
            return $this->error(2002);
        try {
            $data_token = JWTAuth::parseToken()->getPayload();
            if (array_key_exists('staff_id', $data_token->get('data')))
                DB::table('rel_app_users_coupons')->where('staff_id', $data_token->get('data')['staff_id'])
                    ->where('coupon_id', Input::get('coupon_id'))
                    ->update(['status' => $status]);
            else
                return $this->error(1019);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
        return $this->output($this->body);
    }

    public function list_user_request()
    {
        try {
            $list_user = array();
            $total_data = 0;
            $data_token = JWTAuth::parseToken()->getPayload();
            if (array_key_exists('staff_id', $data_token->get('data'))) {
                $total_data = DB::table('coupons')
                    ->join('rel_app_users_coupons', 'coupons.id', 'rel_app_users_coupons.coupon_id')
                    ->join('user_profiles', 'user_profiles.app_user_id', 'rel_app_users_coupons.app_user_id')
                    ->where('rel_app_users_coupons.staff_id', '=', $data_token->get('data')['staff_id'])
                    ->where('rel_app_users_coupons.status', '=', 2)
                    ->count();
                if ($total_data > 0) {
                    $list_user = DB::table('coupons')
                        ->join('rel_app_users_coupons', 'coupons.id', 'rel_app_users_coupons.coupon_id')
                        ->join('user_profiles', 'user_profiles.app_user_id', 'rel_app_users_coupons.app_user_id')
                        ->where('rel_app_users_coupons.staff_id', '=', $data_token->get('data')['staff_id'])
                        ->where('rel_app_users_coupons.status', '=', 2)
                        ->select('rel_app_users_coupons.coupon_id', 'rel_app_users_coupons.app_user_id', 'coupons.title'
                            , 'coupons.description', 'coupons.image_url', 'user_profiles.name', 'rel_app_users_coupons.user_use_date')
                        ->get();
                    for ($i = 0; $i < count($list_user); $i++) {
                        $list_user[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $list_user[$i]->image_url);
                    }
                }
            } else
                return $this->error(1019);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            print_r($e->getMessage());
            die;
            return $this->error(9999);
        }

        $this->body['data']['list_request'] = $list_user;
        $this->body['data']['total'] = $total_data;

        return $this->output($this->body);
    }
}