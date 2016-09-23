<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TopsRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\UserSession;
use App\Models\AppUser;
use App\Models\UserProfile;
use App\Models\UserPush;
use App\Utils\RedisUtil;
use App\Models\SocialProfile;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Address;
use Illuminate\Support\Facades\Hash;
use DB; 
use Twitter;
use Illuminate\Support\Facades\Config;
use App\Jobs\InstagramHashtagJob;
use App\Utils\UrlHelper;

class AppUserController extends Controller
{
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function verify_facebook_token($id, $token)
    {
        try {
            $graph_url = "https://graph.facebook.com/me?access_token=" . $token;
            $json = @file_get_contents($graph_url);
            if ($json === false)
                return false;

            $profile = json_decode($json, true);
            if ($id != $profile['id'])
                return false;

            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function verify_twitter_token($id, $token, $secret)
    {
        // set the new configurations
        Twitter::reconfig([
            // "token" => '2248083320-oz6gVmtW8vRal4sO1ouM34lklztCQ61pyaQX2Hb',
            // "secret" => 'hXc9ShqBGF0ajy8MakX7zsbJ87EXILuhpDnVVYGvQSSW6',
            "token" => $token,
            "secret" => $secret,
        ]);

        try {
            $credentials = Twitter::getCredentials();
            if ($id != $credentials->id)
                return false;

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }


    public function social_login(Request $request)
    {

        if (Input::get('social_type') == 1) {
            $check_items = array('app_id', 'name', 'social_type', 'social_id', 'social_token', 'time', 'sig');

            if ($this->verify_facebook_token(Input::get('social_id'), Input::get('social_token')) == false) {
                return $this->error(9998);
            }
        } else if (Input::get('social_type') == 2) {
            $check_items = array('app_id', 'name', 'social_type', 'social_id', 'social_token', 'social_secret', 'time', 'sig');

            if ($this->verify_twitter_token(Input::get('social_id'), Input::get('social_token'), Input::get('social_secret')) == false) {
                return $this->error(9998);
            }
        } else {
            return $this->error(1004);
        }

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_social_login');//array('app_id', 'time', 'social_type', 'social_id');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if (!$app)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        $user = null;
        try {
            $user = AppUser::where('social_id', Input::get('social_id'))->where('app_id', $app['id'])->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }


        if (!$user) {
            try {
                DB::beginTransaction();

                $user = new AppUser();
                $user->app_id = $app['id'];
                $user->social_type = Input::get('social_type');
                $user->social_id = Input::get('social_id');
                $user->save();

                $profile = new UserProfile();
                $profile->name = Input::get('name');
                $profile->app_user_id = $user->id;
                $profile->gender = 0;
                $profile->address = null;
                $profile->avatar_url = null;
                $profile->facebook_status = 0;
                $profile->twitter_status = 0;
                $profile->instagram_status = 0;

                $profile->save();

                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                return $this->error(9999);
            }
        } else {
            $profile = UserProfile::where('app_user_id', $user->id)->select(['name', 'gender', 'address', 'avatar_url', 'facebook_status', 'twitter_status', 'instagram_status'])->first();
        }

        $token = md5(Input::get('email') . date('Y-m-d H:i:s'));
        try {
            UserSession::where('app_user_id', $user->id)->delete();
            $user_session = new UserSession();
            $user_session->token = $token;
            $user_session->type = 1;
            $user_session->app_user_id = $user->id;
            $user_session->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['token'] = $token;
        $this->body['data']['app_id'] = $user->app_id;
        $this->body['data']['id'] = $user->id;
        $this->body['data']['email'] = NULL;
        $this->body['data']['social_type'] = Input::get('social_type');
        $this->body['data']['social_id'] = Input::get('social_id');
        $this->body['data']['profile'] = $profile;
        return $this->output($this->body);

    }

    public function signup(Request $request)
    {

        $check_items = array('app_id', 'email', 'password', 'name', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_signup');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if (!$app)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        try {
            $user = AppUser::where('email', Input::get('email'))->where('app_id', $app['id'])->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        if ($user)
            return $this->error(9996);

        try {
            DB::beginTransaction();
            $user = new AppUser();
            $user->email = Input::get('email');
            $user->password = bcrypt(Input::get('password'));
            $user->app_id = $app['id'];
            $user->save();

            $profile = new UserProfile();
            $profile->name = Input::get('name');
            $profile->gender = 0;
            $profile->address = null;
            $profile->avatar_url = null;
            $profile->facebook_status = 0;
            $profile->twitter_status = 0;
            $profile->instagram_status = 0;
            $profile->app_user_id = $user->id;

            $profile->save();

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }

        $token = md5(Input::get('email') . date('Y-m-d H:i:s'));
        try {
            UserSession::where('app_user_id', $user->id)->delete();
            $user_session = new UserSession();
            $user_session->token = $token;
            $user_session->type = 0;
            $user_session->app_user_id = $user->id;
            $user_session->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['token'] = $token;
        $this->body['data']['app_id'] = $user->app_id;
        $this->body['data']['id'] = $user->id;
        $this->body['data']['email'] = Input::get('email');
        $this->body['data']['social_type'] = NULL;
        $this->body['data']['social_id'] = NULL;
        $this->body['data']['profile'] = $profile;


        return $this->output($this->body);
    }

    public function signin(Request $request)
    {

        $check_items = array('email', 'password', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_signin');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if (!$app)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        try {
            $user = AppUser::where('email', Input::get('email'))->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }


        if ($user && Hash::check(Input::get('password'), $user->password)) {
            $token = md5(Input::get('email') . date('Y-m-d H:i:s'));

            try {
                $profile = UserProfile::where('app_user_id', $user->id)->select(['name', 'gender', 'address', 'avatar_url', 'facebook_status', 'twitter_status', 'instagram_status'])->first();

                UserSession::where('app_user_id', $user->id)->delete();
                $user_session = new UserSession();
                $user_session->token = $token;
                $user_session->type = 0;
                $user_session->app_user_id = $user->id;
                $user_session->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return $this->error(9999);
            }

            $this->body['data']['token'] = $token;
            $this->body['data']['app_id'] = $user->app_id;
            $this->body['data']['id'] = $user->id;
            $this->body['data']['email'] = Input::get('email');
            $this->body['data']['social_type'] = NULL;
            $this->body['data']['social_id'] = NULL;
            $this->body['data']['profile'] = $profile;
            return $this->output($this->body);
        } else {
            return $this->error(9995);
        }


    }


    public function signout(Request $request)
    {

        $check_items = array('token', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_signin');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));
        if (!$app)
            return $this->error(9998);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        try {
            UserSession::where('app_user_id', $request->user->id)->delete();
            $request->user->android_push_key = null;
            $request->user->apple_push_key = null;
            $request->user->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    public function set_push_key(Request $request)
    {

        $check_items = array('token', 'client', 'key', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (Input::get('client') == 0)
            $request->user->android_push_key = Input::get('key');
        else
            $request->user->apple_push_key = Input::get('key');

        $request->user->save();
        return $this->output($this->body);
    }


    public function set_push_setting(Request $request)
    {

        $check_items = array('token', 'ranking', 'news', 'coupon', 'chat', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $push = UserPush::where('app_user_id', $request->user->id)->first();

        if (!$push)
            $push =  new UserPush();

        $push->ranking = Input::get('ranking');
        $push->news = Input::get('news');
        $push->coupon = Input::get('coupon');
        $push->chat = Input::get('chat');

        $push->save();

        return $this->output($this->body);
    }

    public function profile(Request $request)
    {
        $check_items = array('token', 'time', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (!$request->user || !$request->user->profile)
            return $this->error(1004);

        //validate sig
        $check_sig_items = Config::get('api.sig_profile');
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //creare key redis
        Log::info("config: ".Config::get('api.cache_profile'));
        Log::info("app_app_id: ".$app['app_app_id']);
        Log::info("user->profile->id: ".$request->user->profile->id);

        $key = sprintf(Config::get('api.cache_profile'), $app['app_app_id'],$request->user->profile->id);
        Log::info("key: ".$key);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        $request->user->profile->avatar_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$request->user->profile->avatar_url);
        $this->body['data']['user'] = $request->user;

        if ($request->user != null && count($request->user) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }

        return $this->output($this->body);
    }


    public function update_profile(Request $request)
    {

        $check_items = array('token', 'username', 'gender', 'address', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        //validate sig
        $check_sig_items = Config::get('api.sig_profile');
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;


        if (Input::get('gender') != '0' && Input::get('gender') != '1')
            return $this->error(1004);

        if (Input::file('avatar') != null && Input::file('avatar')->isValid()) {
            $file = array('avatar' => Input::file('avatar'));
            $destinationPath = 'uploads'; // upload path
            $extension = Input::file('avatar')->getClientOriginalExtension(); // getting image extension
            $fileName = md5(Input::file('avatar')->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            Input::file('avatar')->move($destinationPath, $fileName); // uploading file to given path
            $request->user->profile->avatar_url = $destinationPath . '/' . $fileName;
        } else {
            return $this->error(1004);
        }

        try {
            $request->user->profile->name = Input::get('username');
            $request->user->profile->gender = Input::get('gender');
            $request->user->profile->address = Input::get('address');
            $request->user->profile->save();

            $key = sprintf(Config::get('api.cache_profile'), $app['app_app_id'],$request->user->id);

            RedisUtil::getInstance()->clear_cache($key);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    public function social_profile(Request $request)
    {

        $check_items = array('token', 'social_type', 'social_id', 'social_token', 'social_secret',  'nickname', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (!$request->user || !$request->user->profile)
            return $this->error(1004);

        //validate sig
        $check_sig_items = Config::get('api.sig_social_profile');
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;

        try {
            $social_profile = new SocialProfile();
            $social_profile->app_user_id = $request->user->id;
            $social_profile->social_type = Input::get('social_type');
            $social_profile->social_id = Input::get('social_id');
            $social_profile->social_token = Input::get('social_token');
            $social_profile->social_secret = Input::get('social_secret');
            $social_profile->nickname = Input::get('nickname');
            $social_profile->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

}
