<?php

namespace App\Http\Controllers;

use App\User;
use App\UserRefreshToken;
use App\Utils\HttpUtils;
use App\Utils\PseudoCrypt;
use App\Utils\RedisUtil;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Log;
use JWTAuth;

class UserV1Controller extends Controller
{


    public function __construct()
    {
    }

    public function test(Request $request)
    {
        $tmp = PseudoCrypt::hash(10000000, 5);
        $this->body['data']['tmp'] = $tmp;
        $tmp1 = PseudoCrypt::unhash($tmp);
        $this->body['data']['tmp1'] = $tmp1;
        $this->body['data']['uri'] = $request->url();
        $path = $request->path();
        $pos = strpos($request->url(), $path);
        $this->body['data']['pos'] = $pos;
        $this->body['data']['url'] = substr($request->url(), 0, $pos);
        return $this->output($this->body);
    }

    public function profile()
    {
        $user = \Tymon\JWTAuth\Facades\JWTAuth::toUser();
        if (!$user)
            return $this->error(1004);
        $key_redis = 'profile_' . $user->id . '_' . $user->email;
        $dataCache = RedisUtil::getInstance()->get_cache($key_redis);
        if (count($dataCache) > 0)
            $this->body['data'] = $dataCache;
        else {
//        $data = User::find($user->id)->roles()->get();
            $data = User::whereEmail($user->email)->with('roles')->first();
            if (count($data) > 0)
                RedisUtil::getInstance()->set_cache($key_redis, $data);
            $this->body['data'] = $data;
        }
        return $this->output($this->body);
    }

    public function change_password()
    {
        $check_items = array('old_password', 'new_password');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $user = \Tymon\JWTAuth\Facades\JWTAuth::toUser();
        if (!$user)
            return $this->error(1004);

        if (!Hash::check(Input::get('old_password'), $user->password))
            return $this->error(99956);
        try {
            $user_data = User::find($user->id);
            $user_data->password = app('hash')->make(Input::get('new_password'));
            $user_data->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
        return $this->output($this->body);
    }

    public function check_user_exist(Request $request)
    {
        $check_items = array('email');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        try {
            $user = User::where('email', '=', Input::get('email'))->first();
            if (count($user) > 0) {
                $this->body['data']['auth_user_id'] = $user->id;
                return $this->output($this->body);
            } else
                return $this->error(99953);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
    }

    public function register(Request $request)
    {

        $check_items = array('email', 'password', 'role','platform');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
        } catch (HttpResponseException $e) {
            return $this->error(1004);
        }

        if (Input::get('role') == 'admin')
            return $this->error(1004);

        try {
            $user = User::where('email', Input::get('email'))->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        if ($user) {
            if (!$user->isRole(Input::get('role'))) {
                $role = Role::whereSlug(Input::get('role'))->first();
                if ($role)
                    $user->attachRole($role);
            } else {
                return $this->error(9996);
            }

        } else {
            try {
                DB::beginTransaction();
                $user = new User();
                $user->email = Input::get('email');
                if (Input::get('role') == 'client')
                    $user->active = 0;
                else
                    $user->active = 1;
                $user->password = app('hash')->make(Input::get('password'));
                $user->save();

                $role = Role::whereSlug(Input::get('role'))->first();
                if ($role)
                    $user->attachRole($role);
                else {
                    DB::rollBack();
                    return $this->error(1004);
                }

                $user->save();

                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                return $this->error(9999);
            }

        }


        $user = User::whereEmail(Input::get('email'))->with('roles')->first();

        $credentials = array();
        $credentials['email'] = Input::get('email');
        $credentials['password'] = Input::get('password');


        if ($user && $user->roles && count($user->roles) > 0 && $token = JWTAuth::attempt($credentials, ['role' => $user->roles[0]->slug, 
                'id' => $user->id,'platform' => Input::get('platform')])) {
            $this->body['data']['token'] = (string)$token;
            $this->body['data']['auth_user_id'] = $user->id;
//                $refresh_token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addMinutes(Config::get('jwt.refresh_ttl'))->timestamp, 'id' => $user->id]);
//                $this->body['data']['refresh_token'] = (string)$refresh_token;
            $refresh_token = md5($user->id . Carbon::now());
            $this->body['data']['refresh_token'] = $refresh_token;
            $user_id_code = PseudoCrypt::hash($user->id);
            $this->body['data']['access_refresh_token_href'] = HttpUtils::get_refresh_token_url($request, $user_id_code, $refresh_token);
            //insert refresh token

            $refresh = UserRefreshToken::where('user_id', $user->id)->first();

            if (count($refresh) > 0) {
                $refresh->refresh_token = $refresh_token;
                $refresh->user_id_code = $user_id_code;
                $refresh->time_expire = Carbon::now()->addMinutes(Config::get('jwt.refresh_ttl'))->timestamp;
                $refresh->save();
            } else {
                $refresh = new UserRefreshToken();
                $refresh->refresh_token = $refresh_token;
                $refresh->user_id = $user->id;
                $refresh->user_id_code = $user_id_code;
                $refresh->time_expire = Carbon::now()->addMinutes(Config::get('jwt.refresh_ttl'))->timestamp;
                $refresh->save();
            }
            return $this->output($this->body);
        } else {
            return $this->error(9995);
        }

        return $this->output($this->body);
    }

    public function userlist(Request $request)
    {
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);

        if ($user->isRole('admin')) {
            $userlist = User::with('roles')->get();
            $this->body['data'] = $userlist;
            return $this->output($this->body);
        } else {
            return $this->error(9997);
        }

    }

    public function signout(Request $request)
    {
        //delete fresh token
        //delete key notification
        return $this->output($this->body);
    }


}