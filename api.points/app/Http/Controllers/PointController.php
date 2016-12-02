<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/31/16
 * Time: 5:35 AM
 */

namespace App\Http\Controllers;


use App\Models\Point;
use App\Models\PointRequestHistory;
use App\Models\PointSetting;
use App\Utils\HttpRequestUtil;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class PointController extends Controller
{
    public function __construct()
    {


    }

    public function set_point_setting()
    {
        $check_items = array('app_id', 'yen_to_mile', 'mile_to_point', 'bonus_miles_1', 'bonus_miles_2', 'max_point_use', 'rank1', 'rank2', 'rank3', 'rank4');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_role != 'client' && ($auth_role != 'admin')) {
            return $this->error(9997);
        } 

        if ($auth_id > 0) {
            try {
                $point_setting = PointSetting::getPointSetting(Input::get('app_id'));
                $point_setting->mile_to_point = Input::get('mile_to_point');
                $point_setting->yen_to_mile = Input::get('yen_to_mile');
                $point_setting->bonus_miles_1 = Input::get('bonus_miles_1');
                $point_setting->bonus_miles_2 = Input::get('bonus_miles_2');
                $point_setting->max_point_use = Input::get('max_point_use');
                $point_setting->rank1 = Input::get('rank1');
                $point_setting->rank2 = Input::get('rank2');
                $point_setting->rank3 = Input::get('rank3');
                $point_setting->rank4 = Input::get('rank4');
                $point_setting->save();
                return $this->output($this->body);
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }

    public function set_payment_method()
    {
        $check_items = array('app_id', 'payment_method');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_role != 'client' && ($auth_role != 'admin')) {
            return $this->error(9997);
        } 

        if ($auth_id > 0) {
            try {
                $point_setting = PointSetting::getPointSetting(Input::get('app_id'));
                $point_setting->payment_method = Input::get('payment_method');
                $point_setting->save();
                return $this->output($this->body);
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }


    public function get_client_point_info()
    {
        $check_items = array('app_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_role != 'client' && ($auth_role != 'admin')) {
            return $this->error(9997);
        } 

        if ($auth_id > 0) {
            try {
                $point_info = Point::getPoint($auth_id);
                $point_setting = PointSetting::getPointSetting(Input::get('app_id'));

                $monthly_mile = PointRequestHistory::where('app_app_id', Input::get('app_id'))
                    ->where('status', 1)
                    ->where('action', 'use')
                    ->whereMonth('updated_at', '=', date('m'))
                    ->where('role_request', 'user')->select('miles', 'yen_to_mile')->get();
                $monthly_revenue = 0;
                //dd($monthly_mile);
                foreach ($monthly_mile as $value) {
                    $monthly_revenue += $value->miles * $value->yen_to_mile;
                }
                $this->body['data']['monthly_revenue'] = -$monthly_revenue;
                $this->body['data']['point'] = $point_info;
                $this->body['data']['point_setting'] = $point_setting;
                return $this->output($this->body);
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }

    public function get_point_info()
    {
        $check_items = array('app_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        if ($auth_id > 0) {
            try {
                $point_setting = PointSetting::getPointSetting(Input::get('app_id'));

                $point_info = Point::getPoint($auth_id);
               
                if ($point_info->miles > 0) {
                    $point_info->points = intval($point_info->miles/$point_setting->mile_to_point);
                          
                    $tmp_point = $point_info->points % 100;
                    $add_point = 100 - $tmp_point;
                    $point_info->next_points = $point_info->points + $add_point;
                    $point_info->next_miles = $point_info->miles + ($point_setting->mile_to_point * $add_point);
                } else {
                    $point_info->miles = 0;
                    $point_info->point = 0;
                    $point_info->next_points = 100;
                    $point_info->next_miles = $point_info->next_points*$point_setting->mile_to_point;
                }

                $this->body['data'] = $point_info;
                return $this->output($this->body);
               
                    
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }

    public function request_point_for_end_user()
    {
        $check_items = array('app_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_id > 0) {
            try {
                $data = PointRequestHistory::where('user_request_id', '=', $auth_id)
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)
                    ->where('action', 'get')
                    ->where('role_request', 'user')->first();
                if ($data) {
                    return $this->error(99954);
                } else {
                    $point_request = new PointRequestHistory();
                    $point_request->user_request_id = $auth_id;
                    $point_request->role_request = 'user';
                    $point_request->app_app_id = Input::get('app_id');
                    $point_request->status = 0; //new
                    $point_request->action = 'get';
                    $point_request->save();
                    return $this->output($this->body);
                }
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }

    public function approve_request_point_for_end_user()
    {
        $check_items = array('app_id', 'action', 'user_request_id', 'bill_amount');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (Input::get('bill_amount') < 0)
            return $this->error(1004);

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_role = $data_token->get('role');
        if ($auth_role != 'client' && ($auth_role != 'admin')) {
            return $this->error(9997);
        } 
   
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_id > 0) {
            $data = array();
            try {
                $data = PointRequestHistory::where('user_request_id', '=', Input::get('user_request_id'))
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)
                    ->where('action', 'get')
                    ->where('role_request', 'user')->first();

            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }

            if (!$data) {
                return $this->error(99955);
            } else {
                try {
                    DB::beginTransaction();
                    if (Input::get('action') == 'approve') {
                        $point_setting = PointSetting::getPointSetting(Input::get('app_id'));

                        $data->user_action_id = $auth_id;
                        $data->role_action = $auth_role;
                        $data->yen_to_mile = $point_setting->yen_to_mile;
                        $data->mile_to_point = $point_setting->mile_to_point;
                        $data->miles = Input::get('bill_amount')/$point_setting->yen_to_mile + $point_setting->bonus_miles_2; //bonus miles 2 is shop comming bonus
                        $data->status = 1; //accept
                        $data->save();

                        $point_info = Point::getPoint($auth_id);
                        $point_info->miles += $data->miles;
                        $point_info->save();
                    } else {
                        $data->user_action_id = $auth_id;
                        $data->role_action = $auth_role;
                        $data->status = 2; // reject
                        $data->save();
                    }

                    DB::commit();

                    return $this->output($this->body);
                } catch (QueryException $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }
            }
        } else {
            return $this->error(99953);
        }
    }

    public function request_use_point_for_end_user()
    {
        $check_items = array('app_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_id > 0) {
            try {
                $data = PointRequestHistory::where('user_request_id', '=', $auth_id)
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)
                    ->where('action', 'use')
                    ->where('role_request', 'user')->first();
                if ($data) {
                    return $this->error(99954);
                } else {
                    $point_request = new PointRequestHistory();
                    $point_request->user_request_id = $auth_id;
                    $point_request->role_request = 'user';
                    $point_request->app_app_id = Input::get('app_id');
                    $point_request->status = 0; //new
                    $point_request->action = 'use';
                    $point_request->save();
                    return $this->output($this->body);
                }
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }


    public function approve_use_point_for_end_user()
    {
        $check_items = array('app_id', 'action', 'user_request_id', 'use_point');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (Input::get('use_point') < 0)
            return $this->error(1004);

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_role != 'client' && ($auth_role != 'admin')) {
            return $this->error(9997);
        } 
        if ($auth_id > 0) {
            $data = array();
            try {
                $data = PointRequestHistory::where('user_request_id', '=', Input::get('user_request_id'))
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)
                    ->where('action', 'use')
                    ->where('role_request', 'user')->first();

            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }

            if (!$data) {
                return $this->error(99955);
            } else {
                try {
                    DB::beginTransaction();
                    if (Input::get('action') == 'approve') {
                        $point_setting = PointSetting::getPointSetting(Input::get('app_id'));
                        $point_info = Point::getPoint($auth_id);
                        //dd($point_info->miles);
                        //dd( Input::get('use_point')*$point_setting->mile_to_point);
                        if ($point_info->miles < Input::get('use_point')*$point_setting->mile_to_point)
                            return $this->error(9994);

                        if (Input::get('use_point')*$point_setting->mile_to_point > $point_setting->max_point_use)
                            return $this->error(99941);

                        $data->user_action_id = $auth_id;
                        $data->role_action = $auth_role;
                        $data->yen_to_mile = $point_setting->yen_to_mile;
                        $data->mile_to_point = $point_setting->mile_to_point;
                        $data->miles = -1 * (Input::get('use_point')*$point_setting->mile_to_point);
                        $data->status = 1; //accept
                        $data->save();

                        $point_info->miles += $data->miles;
                        $point_info->save();
                    } else {
                        $data->user_action_id = $auth_id;
                        $data->role_action = $auth_role;
                        $data->status = 2; // reject
                        $data->save();
                    }

                    DB::commit();

                    return $this->output($this->body);
                } catch (QueryException $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return $this->error(9999);
                }
            }
        } else {
            return $this->error(99953);
        }
    }

    public function request_list()
    {
        $check_items = array('app_id', 'pageindex', 'pagesize');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);
//
        $skip = (Input::get('pageindex') - 1) * Input::get('pagesize');
        if ($auth_id > 0) {
            try {
                $total_item = PointRequestHistory::where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)->where('action', 'get')->count();
                if ($total_item > 0) {
                    $items = PointRequestHistory::orderBy('updated_at', 'desc')->where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)->where('action', 'get')->skip($skip)->take(Input::get('pagesize'))->get()->toArray();

                    $token = (string)JWTAuth::parseToken()->getToken();
                    for ($i = 0; $i < count($items); $i++) {
                        $data = HttpRequestUtil::getInstance()->get_data_with_token(Config::get('api.auth_profile_url'), $token);
                        if ($data) {
                            $items[$i]['email'] = $data->email;
                            $items[$i]['name'] = $data->name;
                        } else {
                            $items[$i]['email'] = '';
                            $items[$i]['name'] = '';
                        }
                    }
//
                    $this->body['data']['total_item'] = $total_item;
                    $this->body['data']['items'] = $items;
                }
                return $this->output($this->body);

            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }

    public function use_list()
    {
        $check_items = array('app_id', 'pageindex', 'pagesize');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);
//
        $skip = (Input::get('pageindex') - 1) * Input::get('pagesize');
        if ($auth_id > 0) {
            try {
                $total_item = PointRequestHistory::where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)->where('action', 'use')->count();
                if ($total_item > 0) {
                    $items = PointRequestHistory::orderBy('updated_at', 'desc')->where('app_app_id', Input::get('app_id'))
                    ->where('status', 0)->where('action', 'use')->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
                    $token = (string)JWTAuth::parseToken()->getToken();
                    for ($i = 0; $i < count($items); $i++) {
                        $data = HttpRequestUtil::getInstance()->get_data_with_token(Config::get('api.auth_profile_url'), $token);
                        if ($data) {
                            $items[$i]['email'] = $data->email;
                            $items[$i]['name'] = $data->name;
                        } else {
                            $items[$i]['email'] = '';
                            $items[$i]['name'] = '';
                        }
                    }
                    $this->body['data']['total_item'] = $total_item;
                    $this->body['data']['items'] = $items;
                }
                return $this->output($this->body);

            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(99953);
        }
    }
}
