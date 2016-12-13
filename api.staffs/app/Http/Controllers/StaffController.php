<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/23/16
 * Time: 5:02 PM
 */

namespace App\Http\Controllers;


use App\Utils\HttpRequestUtil;
use App\Utils\UrlHelper;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class StaffController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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

            $data = DB::table('rel_app_users_coupons')//->where('staff_id', Input::get('staff_id'))
            ->where('coupon_id', Input::get('coupon_id'))
                ->where('code', Input::get('code'))
                ->where('status', 2)
                ->select('app_user_id', 'staff_id', 'user_use_date')->first();
            if ($data) {
                try {
                    DB::beginTransaction();
                    DB::table('rel_app_users_coupons')//->where('staff_id', Input::get('staff_id'))
                    ->where('coupon_id', Input::get('coupon_id'))
                        ->where('code', Input::get('code'))
                        ->where('status', 2)
                        ->update(['status' => $status]);
                    DB::table('coupon_approve_history')->insert([
                        'app_user_id' => $data->app_user_id,
                        'coupon_id' => Input::get('coupon_id'),
                        'staff_id' => $data->staff_id,
                        'action' => Input::get('action'),
                        'user_use_date' => $data->user_use_date,
                        'action_date' => Carbon::now()
                    ]);
                    //process notification to user
                    $isCall = $this->call_notification_to_user(Input::get('app_id'), Input::get('coupon_id'), strtolower(Input::get('action')), $this->request->token, $data->app_user_id);
                    if (!$isCall) {
                        DB::rollBack();
                        return $this->error(1022);
                    }
                    DB::commit();
                } catch (QueryException $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }


            } else
                return $this->error(1020);

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
//            print_r($data_token->get('id'));die;
            if ($data_token->get('id')) {
                $total_data = DB::table('coupons')
                    ->join('rel_app_users_coupons', 'coupons.id', 'rel_app_users_coupons.coupon_id')
                    ->join('staffs', 'staffs.id', 'rel_app_users_coupons.staff_id')
                    ->join('user_profiles', 'user_profiles.app_user_id', 'rel_app_users_coupons.app_user_id')
                    ->where('staffs.auth_user_id', '=', $data_token->get('id'))
                    ->where('rel_app_users_coupons.status', '=', 2)
                    ->count();
                if ($total_data > 0) {
                    $list_user = DB::table('coupons')
                        ->join('rel_app_users_coupons', 'coupons.id', 'rel_app_users_coupons.coupon_id')
                        ->join('staffs', 'staffs.id', 'rel_app_users_coupons.staff_id')
                        ->join('user_profiles', 'user_profiles.app_user_id', 'rel_app_users_coupons.app_user_id')
                        ->where('staffs.auth_user_id', '=', $data_token->get('id'))
                        ->where('rel_app_users_coupons.status', '=', 2)
                        ->select('rel_app_users_coupons.coupon_id', 'rel_app_users_coupons.code', 'rel_app_users_coupons.app_user_id', 'coupons.title'
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
            return $this->error(9999);
        }

        $this->body['data']['list_request'] = $list_user;
        $this->body['data']['total'] = $total_data;

        return $this->output($this->body);
    }

    private function call_notification_to_user($app_app_id, $coupon_id, $action, $token, $app_user_id)
    {
        return HttpRequestUtil::getInstance()->post_data_with_token_return_boolean(
            Config::get('api.url_notification_to_user'),
            [
                'app_id' => $app_app_id,
                'type' => 'coupon_use',
                'data_id' => $coupon_id,
                'action' => $action,
                'app_user_id' => $app_user_id
            ], $token);
    }
}