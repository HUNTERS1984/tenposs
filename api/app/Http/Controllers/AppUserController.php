<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\News;
use App\Models\ShareCodeInfo;
use App\Models\User;
use App\Models\WebPushCurrent;
use App\Repositories\Contracts\TopsRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\File;
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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
        $facebook_status = 0;
        $twitter_status = 0;
        if (Input::get('social_type') == 1) {
            $check_items = array('app_id', 'name', 'social_type', 'social_id', 'social_token', 'time', 'sig');
            $facebook_status = 1;
            if ($this->verify_facebook_token(Input::get('social_id'), Input::get('social_token')) == false) {
                return $this->error(9998);
            }
        } else if (Input::get('social_type') == 2) {
            $check_items = array('app_id', 'name', 'social_type', 'social_id', 'social_token', 'social_secret', 'time', 'sig');
            $twitter_status = 1;
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
                $profile->facebook_status = $facebook_status;
                $profile->twitter_status = $twitter_status;
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
            // them 3 param moi: app_uuid,source,code
            if (!empty(Input::get('code'))) {
                $error_code = $this->_topRepository->check_share_code($app['id'], Input::get('code'), Input::get('source'), Input::get('app_uuid'), Input::get('email'));
                if ($error_code > 1000)
                    return $this->error($error_code);
            }

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

            //save info used code
            if (!empty(Input::get('code'))) {
                $share_code = ShareCodeInfo::where('code', Input::get('code'))
                    ->where('app_id', $app['id'])->first();
                if (count($share_code) > 0) {
                    $share_code->status = 1;
                    $share_code->app_uuid = Input::get('app_uuid');
                    $share_code->email = Input::get('email');
                    $share_code->save();
                }
            }
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
                if ($profile && !empty($profile->avatar_url))
                    $profile->avatar_url = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url_api'), $profile->avatar_url);
                UserSession::where('app_user_id', $user->id)->delete();
                $user_session = new UserSession();
                $user_session->token = $token;
                $user_session->type = 0;
                $user_session->app_user_id = $user->id;
                $user_session->save();
                $push = UserPush::where('app_user_id', $user->id)->first();
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

            if (!$push) {
                $push = new UserPush();
                $push->ranking = 1;
                $push->news = 1;
                $push->coupon = 1;
                $push->chat = 1;
            }
            $this->body['data']['push_setting'] = $push;
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
        else if (Input::get('client') == 3)
            $request->user->web_push_key = Input::get('key');
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
            $push = new UserPush();

        $push->ranking = Input::get('ranking');
        $push->news = Input::get('news');
        $push->coupon = Input::get('coupon');
        $push->chat = Input::get('chat');
        $push->app_user_id = $request->user->id;

        $push->save();

        return $this->output($this->body);
    }


    public function get_push_setting(Request $request)
    {

        $check_items = array('token', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $push = UserPush::where('app_user_id', $request->user->id)->first();
//        $push = UserPush::where('app_user_id',1)->first();
        if (!$push) {
            $push = new UserPush();
            $push->ranking = 1;
            $push->news = 1;
            $push->coupon = 1;
            $push->chat = 1;
            $push->app_user_id = $request->user->id;
        }
        $this->body['data']['push_setting'] = $push;
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
//        //creare key redis
//        Log::info("config: ".Config::get('api.cache_profile'));
//        Log::info("app_app_id: ".$app['app_app_id']);
//        Log::info("user->profile->id: ".$request->user->profile->id);

        $key = sprintf(Config::get('api.cache_profile'), $app['app_app_id'], $request->user->id);
//        Log::info("key: ".$key);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        $request->user->profile->avatar_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $request->user->profile->avatar_url);
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
        }

        try {
            $request->user->profile->name = Input::get('username');
            $request->user->profile->gender = Input::get('gender');
            $request->user->profile->address = Input::get('address');
            $request->user->profile->save();

            $key = sprintf(Config::get('api.cache_profile'), $app['app_app_id'], $request->user->id);

            RedisUtil::getInstance()->clear_cache($key);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    public function social_profile(Request $request)
    {

        $check_items = array('token', 'social_type', 'social_id', 'social_token', 'nickname', 'time', 'sig');

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
            $social = SocialProfile::where('social_id', Input::get('social_id'))
                ->where('social_type', Input::get('social_type'))
                ->where('app_user_id', $request->user->id)->first();
            if (count($social) > 0) {
                $social->app_user_id = $request->user->id;
                $social->social_type = Input::get('social_type');
                $social->social_id = Input::get('social_id');
                $social->social_token = Input::get('social_token');
                if (Input::get('social_secret'))
                    $social->social_secret = Input::get('social_secret');
                $social->nickname = Input::get('nickname');
                $social->deleted_at = null;
                $social->save();
            } else {
                $social_profile = new SocialProfile();
                $social_profile->app_user_id = $request->user->id;
                $social_profile->social_type = Input::get('social_type');
                $social_profile->social_id = Input::get('social_id');
                $social_profile->social_token = Input::get('social_token');
                if (Input::get('social_secret'))
                    $social_profile->social_secret = Input::get('social_secret');
                $social_profile->nickname = Input::get('nickname');
                $social_profile->save();
            }
            // update status social
            $user_profile = UserProfile::find($request->user->profile->id);
            if ($user_profile) {
                $user_profile->app_user_id = $request->user->id;
                $user_profile->gender = 0;
                if (Input::get('social_type') == 1) {
                    $user_profile->facebook_status = 1;
                    $user_profile->twitter_status = $user_profile->twitter_status > 0 ? $user_profile->twitter_status : 0;
                    $user_profile->instagram_token = $user_profile->instagram_token > 0 ? $user_profile->instagram_token : 0;

                    $user_profile->facebook_token = Input::get('social_token');
                } else if (Input::get('social_type') == 2) {
                    $user_profile->twitter_status = 1;
                    $user_profile->facebook_status = $user_profile->facebook_status > 0 ? $user_profile->facebook_status : 0;
                    $user_profile->instagram_token = $user_profile->instagram_token > 0 ? $user_profile->instagram_token : 0;
                    $user_profile->twitter_token = Input::get('social_token');
                } else if (Input::get('social_type') == 3) {
                    $user_profile->instagram_status = 1;
                    $user_profile->facebook_status = $user_profile->facebook_status > 0 ? $user_profile->facebook_status : 0;
                    $user_profile->twitter_status = $user_profile->twitter_status > 0 ? $user_profile->twitter_status : 0;
                    $user_profile->instagram_token = Input::get('social_token');
                }
                $user_profile->save();
            }
            $key = sprintf(Config::get('api.cache_profile'), $app['app_app_id'], $request->user->id);
            RedisUtil::getInstance()->clear_cache($key);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    public function social_profile_cancel(Request $request)
    {

        $check_items = array('token', 'social_type', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (!$request->user || !$request->user->profile)
            return $this->error(1004);

        //validate sig
        $check_sig_items = Config::get('api.sig_social_profile_cancel');
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        try {
            $app_user_id = $request->user->id;
            if ($app_user_id > 0) {
                $social_profile = SocialProfile::where('app_user_id', $app_user_id)
                    ->where('social_type', Input::get('social_type'))->first();
                $social_profile->deleted_at = Carbon::now();
                $social_profile->save();

            }
            // update status social
            $user_profile = UserProfile::find($request->user->profile->id);
            if ($user_profile) {

                if (Input::get('social_type') == 1) {
                    $user_profile->facebook_status = 0;
                    $user_profile->twitter_status = $user_profile->twitter_status > 0 ? $user_profile->twitter_status : 0;
                    $user_profile->instagram_token = $user_profile->instagram_token > 0 ? $user_profile->instagram_token : 0;

                    $user_profile->facebook_token = Input::get('social_token');
                } else if (Input::get('social_type') == 2) {
                    $user_profile->twitter_status = 0;
                    $user_profile->facebook_status = $user_profile->facebook_status > 0 ? $user_profile->facebook_status : 0;
                    $user_profile->instagram_token = $user_profile->instagram_token > 0 ? $user_profile->instagram_token : 0;
                    $user_profile->twitter_token = Input::get('social_token');
                } else if (Input::get('social_type') == 3) {
                    $user_profile->instagram_status = 0;
                    $user_profile->facebook_status = $user_profile->facebook_status > 0 ? $user_profile->facebook_status : 0;
                    $user_profile->twitter_status = $user_profile->twitter_status > 0 ? $user_profile->twitter_status : 0;
                    $user_profile->instagram_token = Input::get('social_token');
                }
                $user_profile->save();
            }
            $key = sprintf(Config::get('api.cache_profile'), $app['app_app_id'], $request->user->id);
            RedisUtil::getInstance()->clear_cache($key);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }


    public function get_app_by_domain(Request $request)
    {
        $check_items = array('domain', 'time', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //validate sig
        $check_sig_items = Config::get('api.sig_app_domain');

        $ret_sig = $this->validate_sig($check_sig_items, Config::get('api.secret_key_for_domain'));
        if ($ret_sig)
            return $ret_sig;
//        //creare key redis

        $key = sprintf(Config::get('api.cache_app_domain'), urlencode(Input::get('domain')));
//        Log::info("key: ".$key);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        $rs_data = array();
        try {
            //$app_info = User::where('domain', Input::get('domain'))->with('apps')->first();
            $app_info = App\Models\App::where('domain', Input::get('domain'))->first();
            if (count($app_info) > 0) {
                //if (count($app_info['apps']) > 0)
                    //$rs_data = $app_info['apps'][0];
                    $rs_data = $app_info;
            }

        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        $this->body['data']['app_info'] = $rs_data;
        if (count($rs_data) > 0) { // set cache
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);
    }

    public function get_data_web_notification()
    {
        $check_items = array('app_id', 'key', 'time', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //validate sig
        $check_sig_items = Config::get('api.sig_web_push_current');
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));

        if ($app == null || count($app) == 0)
            return $this->error(1004);

        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;

        $info_notify = array();
        $info_data = array();
        try {
            $info_notify = WebPushCurrent::whereRaw('app_user_id = ? and `key` = ?', [$app['id'], Input::get('key')])->orderBy('created_at', 'desc')->first();
            if ($info_notify) {
                switch ($info_notify->type) {
                    case "news":
                        $info_data = News::where('id', $info_notify->data_id)->first();
                        break;
                    case "coupon":
                        $info_data = Coupon::where('id', $info_notify->data_id)->first();
                        break;
                    case "chat":
                        if (!empty($info_notify->data_value)) {
                            $info_data = array('title' => $info_notify->title,
                                'description' => $info_notify->data_value);
                        }
                        break;
                    case "custom":
                        if (!empty($info_notify->data_value)) {
                            $info_data = array('title' => $info_notify->title,
                                'description' => $info_notify->data_value);
                        }
                        break;
                    default:
                        break;
                }
            }
        } catch (QueryException $e) {

            Log::error($e->getMessage());
            return $this->error(9999);
        }
        $this->body['data']['info'] = $info_notify;
        $this->body['data']['detail'] = $info_data;
        return $this->output($this->body);
    }

    public function delete_data_web_notification()
    {
        $check_items = array('app_id', 'id', 'time', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //validate sig
        $check_sig_items = Config::get('api.sig_delete_data_web_notification');
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);

        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        try {
            $web_push = WebPushCurrent::find(Input::get('id'));
            if ($web_push)
                $web_push->delete();

        } catch (QueryException $e) {

            Log::error($e->getMessage());
            return $this->error(9999);
        }
        return $this->output($this->body);
    }

    public function share_get_code()
    {
        $check_items = array('app_id', 'time', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_share_get_code');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        $code = '';
        try {
            $code = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
            $share_code = new \App\Models\ShareCodeInfo();
            $share_code->code = $code;
            $share_code->app_id = $app['id'];
            $share_code->save();
        } catch (\Doctrine\DBAL\Query\QueryException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }

        $this->body['data']['code'] = $code;//strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));

        return $this->output($this->body);

    }

    public function create_virtual_host()
    {

        $check_items = array('domain', 'domain_type', 'time', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //validate sig
        $check_sig_items = Config::get('api.sig_create_virtual_host');

        $ret_sig = $this->validate_sig($check_sig_items, Config::get('api.secret_key_for_domain'));
        if ($ret_sig)
            return $ret_sig;
        $domain = '';
        if (Input::get('domain_type') == 'main')
            $domain = Input::get('domain');
        else if (Input::get('domain_type') == 'sub')
            $domain = Input::get('domain') . '.ten-po.com';
        if (!empty($domain)) {
            try {
                $source_file = public_path('assets/template/apache-host.txt'); // upload path
                $template = file_get_contents($source_file);
                $template = str_replace("#domain#", $domain, $template);
                $dest_file = Config::get('api.path_host_apache_site_available');
                $newFile = fopen($dest_file . $domain . '.conf', 'w');
                fwrite($newFile, $template);
                fclose($newFile);
            } catch (FileNotFoundException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            } catch (FileException $e) {
                Log::error($e->getMessage());
                return $this->error(9999);
            }
        } else {
            return $this->error(1019);
        }
        return $this->output($this->body);
    }

}
