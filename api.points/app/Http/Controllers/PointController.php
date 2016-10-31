<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/31/16
 * Time: 5:35 AM
 */

namespace App\Http\Controllers;


use App\Models\Point;
use App\Models\PointRequest;
use App\Models\PointRequestHistory;
use App\Models\PointRequestUse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class PointController extends Controller
{
    public function __construct()
    {


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
                $point_info = DB::table('points')->where('auth_user_id', '=', $auth_id)
                    ->where('app_app_id', '=', Input::get('app_id'))
                    ->select('auth_user_id', 'app_app_id', 'points', 'miles')->get();
                if (count($point_info) > 0) {
                    $this->body['data'] = $point_info;
                    return $this->output($this->body);
                } else
                    return $this->error(99953);
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
        if ($auth_role != 'user')
            $auth_role = 'user';
        if ($auth_id > 0) {
            try {
                $data = PointRequest::where('user_request_id', '=', $auth_id)
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('role_request', $auth_role)->first();
                if (count($data) > 0) {
                    return $this->error(99954);
                } else {
                    $point_request = new PointRequest();
                    $point_request->user_request_id = $auth_id;
                    $point_request->role_request = $auth_role;
                    $point_request->app_app_id = Input::get('app_id');
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

    public function request_point_for_client()
    {
        $check_items = array('app_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_role != 'client')
            $auth_role = 'client';
        if ($auth_id > 0) {
            try {
                $data = PointRequest::where('user_request_id', '=', $auth_id)
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('role_request', $auth_role)->first();
                if (count($data) > 0) {
                    return $this->error(99954);
                } else {
                    $point_request = new PointRequest();
                    $point_request->user_request_id = $auth_id;
                    $point_request->role_request = $auth_role;
                    $point_request->app_app_id = Input::get('app_id');
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
        $check_items = array('app_id', 'action');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_id > 0) {
            $data = array();
            try {
                $data = PointRequest::where('user_request_id', '=', $auth_id)
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('role_request', 'user')->first();

            } catch (QueryException $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return $this->error(9999);
            }

            if (count($data) < 1) {
                return $this->error(99955);
            } else {
                try {
                    DB::beginTransaction();
                    $point_request_history = new PointRequestHistory();
                    $point_request_history->user_request_id = $data->user_request_id;
                    $point_request_history->role_request = $data->role_request;
                    $point_request_history->user_action_id = $auth_id;
                    $point_request_history->role_action = $auth_role;
                    $point_request_history->app_app_id = Input::get('app_id');
                    $point_request_history->action = Input::get('action');
                    $point_request_history->save();
                    DB::table('point_requests')->where('id', $data->id)->delete();
                    if (Input::get('action') == 'approve') {
                        //check user in point table
                        $point_info = DB::table('points')->where('auth_user_id', '=', $data->user_request_id)
                            ->where('app_app_id', '=', Input::get('app_id'))->get();
                        if (count($point_info) < 1) {
                            $point = new Point();
                            $point->auth_user_id = $data->user_request_id;
                            $point->app_app_id = Input::get('app_id');
                            $point->points = 0;
                            $point->miles = 0;
                            $point->active = 1;
                            $point->save();
                        }
                    } else if (Input::get('action') == 'reject') {
                        $point_info = DB::table('points')->where('auth_user_id', '=', $data->user_request_id)
                            ->where('app_app_id', '=', Input::get('app_id'))->get();
                        if (count($point_info) < 1) {
                            $point = new Point();
                            $point->auth_user_id = $data->user_request_id;
                            $point->app_app_id = Input::get('app_id');
                            $point->points = 0;
                            $point->miles = 0;
                            $point->active = 0;
                            $point->save();
                        }
                        DB::commit();
                        return $this->output($this->body);
                    }
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
        $check_items = array('app_id', 'points');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_id > 0) {
            try {
                $data = PointRequestUse::where('user_request_id', '=', $auth_id)
                    ->where('app_app_id', Input::get('app_id'))
                    ->where('role_request', $auth_role)->first();
                if (count($data) > 0) {
                    return $this->error(99954);
                } else {
                    $point_request = new PointRequestUse();
                    $point_request->user_request_id = $auth_id;
                    $point_request->role_request = $auth_role;
                    $point_request->app_app_id = Input::get('app_id');
                    $point_request->points = Input::get('points');
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
        $check_items = array('app_id', 'points');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if ($auth_id > 0) {
            try {

                return $this->output($this->body);

            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
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
                $total_item = PointRequest::all()->count();
                if ($total_item > 0) {
                    $items = PointRequest::orderBy('updated_at', 'desc')->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
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
                $total_item = PointRequestUse::all()->count();
                if ($total_item > 0) {
                    $items = PointRequestUse::orderBy('updated_at', 'desc')->skip($skip)->take(Input::get('pagesize'))->get()->toArray();
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
