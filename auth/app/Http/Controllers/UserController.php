<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Bican\Roles\Models\Role;
use Illuminate\Support\Facades\Hash;
use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{


    public function __construct()
    {


    }


    public function register(Request $request)
    {

        $check_items = array('email', 'password', 'role');

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

        if ($user)
            return $this->error(9996);
        try {
            DB::beginTransaction();
            $user = new User();
            $user->email = Input::get('email');
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

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }

        $user = User::whereEmail(Input::get('email'))->with('roles')->first();

        $credentials = array();
        $credentials['email'] = Input::get('email');
        $credentials['password'] = Input::get('password');

        if ($user && $user->roles && count($user->roles) > 0 && $token = JWTAuth::attempt($credentials, ['role' => $user->roles[0]->slug])) {
            $this->body['data'] = $token;
            return $this->output($this->body);
        } else {
            return $this->error(9995);
        }


        return $this->output($this->body);
    }


    public function register_with_active(Request $request)
    {

        $check_items = array('email', 'password', 'role');

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
        $active_expire_date = Carbon::now();

        if (Input::get('time_expire') > 0)
            $active_expire_date->addHour(Input::get('time_expire'));
        else
            $active_expire_date->addHour(24);

        if ($user)
            return $this->error(9996);
        try {
            DB::beginTransaction();
            $user = new User();
            $user->email = Input::get('email');
            $user->password = app('hash')->make(Input::get('password'));
            $user->active = 0;
            $user->active_code = md5(Input::get('email') . date('Y-m-d H:i:s') . 'tenposs@123');
            $user->active_expire_date = $active_expire_date;
            $user->save();

            $role = Role::whereSlug(Input::get('role'))->first();
            if ($role)
                $user->attachRole($role);
            else {
                DB::rollBack();
                return $this->error(1004);
            }

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }
        $user = User::whereEmail(Input::get('email'))->with('roles')->first();

        $this->body['data'] = $user;
        return $this->output($this->body);
    }


    public function delete(Request $request)
    {
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);

        try {
            DB::beginTransaction();

            $user->detachAllRoles();
            $user->delete();

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    public function profile(Request $request)
    {
        $user = JWTAuth::toUser();
        if (!$user)
            return $this->error(1004);
//        $data = User::find($user->id)->roles()->get();
        $data = User::whereEmail($user->email)->with('roles')->first();
        $this->body['data'] = $data;
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


    public function activate(Request $request)
    {
        $user = JWTAuth::toUser();

        if (!$user)
            return $this->error(1004);
        if ($user->isRole('admin')) {
            $user = User::whereEmail(Input::get('email'))->first();
            if ($user) {
                $user->active = 1;
                $user->save();
                return $this->output($this->body);
            } else {
                return $this->error(1004);
            }
        } else {
            return $this->error(9997);
        }

    }

    public function activate_with_code(Request $request)
    {

        try {
            $user = User::where('email', Input::get('email'))->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        if (!$user)
            return $this->error(99953);
        else {
            try {
                if ($user->active_code != Input::get("active_code"))
                    return $this->error(99951);
                $actvie_expire = Carbon::parse($user->active_expire_date);
                if (!Carbon::now()->gt($actvie_expire))
                    return $this->error(99952);
                $user->active = 1;
                $user->active_expire_date = null;
                $user->active_code = null;
                $user->save();
                $data = User::where('email', Input::get('email'))->with('roles')->first();
            } catch (QueryException $e) {
                return $this->error(9999);
            }
            $this->body['data'] = $data;
            return $this->output($this->body);
        }
    }
}