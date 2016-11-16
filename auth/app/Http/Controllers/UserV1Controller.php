<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils\PseudoCrypt;
use App\Utils\RedisUtil;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
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

}