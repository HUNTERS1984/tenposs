<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\UserSession;
use App\Models\AppUser;
use App\Models\App;
use App\Models\AppSetting;
use App\Models\Store;
use App\Models\Menu;
use App\Models\News;
use App\Models\Item;
use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\Reserve;
use App\Models\UserProfile;
use App\Models\UserPush;
use Mail;
use App\Address;
use Illuminate\Support\Facades\Hash;
use DB;
use Mockery\CountValidator\Exception;

class AppUserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function verify_facebook_token ($id, $token)
    {
        try {
            $graph_url = "https://graph.facebook.com/me?access_token=". $token;
            $json = @file_get_contents($graph_url);
            if ($json === false)
                return false;

            $profile = json_decode($json, true);
            if ($id != $profile['id'])
                return false;

            return true;
        } catch (Exception $e) {
            return false;
        }
        
    }


    public function social_login (Request $request) {

        $check_items = array('app_id', 'username', 'social_type', 'social_id', 'social_token', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if ($this->verify_facebook_token(Input::get('social_id'), Input::get('social_token')) == false) {
            return $this->error(9998);
        }

        if (Input::get('social_type') == 0)
            return $this->error(1004);

        $user = null;
        try {
            $user = AppUser::where('social_id', Input::get('social_id'))->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
       

        if (!$user) {
            try {
                DB::beginTransaction();

                $user = new AppUser();
                $user->app_id = Input::get('app_id');
                $user->social_type = Input::get('social_type');
                $user->social_id = Input::get('social_id');
                $user->save();

                $profile = new UserProfile();
                $profile->name = Input::get('username');
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

        $token  = md5(Input::get('email').date('Y-m-d H:i:s'));
        try {
            UserSession::where('app_user_id', $user->id)->delete();
            $user_session = new UserSession();
            $user_session->token = $token;
            $user_session->type = 1;
            $user_session->app_user_id =  $user->id;
            $user_session->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['token'] = $token;
        $this->body['data']['app_id'] = $user->app_id;
        $this->body['data']['app_user_id'] = $user->id;
        $this->body['data']['profile'] = $profile;
        return $this->output($this->body);

    }

    public function signup(Request $request) {

        $check_items = array('app_id','email', 'password', 'username', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            $user = AppUser::where('email', Input::get('email'))->first();
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
            $user->app_id =  Input::get('app_id');
            $user->save();

            $profile = new UserProfile();
            $profile->name = Input::get('username');
            $profile->gender = 0;
            $profile->address = null;
            $profile->avatar_url = null;
            $profile->facebook_status = 0;
            $profile->twitter_status = 0;
            $profile->instagram_status = 0;
            $profile->app_user_id =  $user->id;

            $profile->save();

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->error(9999);
        }

        $token  = md5(Input::get('email').date('Y-m-d H:i:s'));
        try {
            UserSession::where('app_user_id', $user->id)->delete();
            $user_session = new UserSession();
            $user_session->token = $token;
            $user_session->type = 0;
            $user_session->app_user_id =  $user->id;
            $user_session->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        $this->body['data']['token'] = $token;
        $this->body['data']['app_id'] = $user->app_id;
        $this->body['data']['app_user_id'] = $user->id;
        $this->body['data']['profile'] = $profile;


        return $this->output($this->body);
    }

    public function signin(Request $request) {

        $check_items = array('email', 'password', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            $user = AppUser::where('email', Input::get('email'))->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
       

        if ($user && Hash::check(Input::get('password'), $user->password)) {
            $token  = md5(Input::get('email').date('Y-m-d H:i:s'));

            try {
                $profile = UserProfile::where('app_user_id', $user->id)->select(['name', 'gender', 'address', 'avatar_url', 'facebook_status', 'twitter_status', 'instagram_status'])->first();

                UserSession::where('app_user_id', $user->id)->delete();
                $user_session = new UserSession();
                $user_session->token = $token;
                $user_session->type = 0;
                $user_session->app_user_id =  $user->id;
                $user_session->save();
            } catch (\Illuminate\Database\QueryException $e) {
                return $this->error(9999);
            }

            $this->body['data']['token'] = $token;
            $this->body['data']['app_id'] = $user->app_id;
            $this->body['data']['app_user_id'] = $user->id;
            $this->body['data']['profile'] = $profile;
            return $this->output($this->body);
        } else {
            return $this->error(9995);
        }

        
    }


    public function signout(Request $request) {
        
        $check_items = array('token', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

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

    public function set_push_key(Request $request) {

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


    public function set_push_setting(Request $request) {

        $check_items = array('token', 'ranking', 'news', 'coupon', 'chat', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $push = UserPush::where('app_user_id', $request->user->id)->first();
        
        if (!$push)
            return $this->error(1004); 

        $push->ranking = Input::get('ranking');
        $push->news = Input::get('news');
        $push->coupon = Input::get('coupon');
        $push->chat = Input::get('chat');

        $push->save();

        return $this->output($this->body);
    }

    public function profile(Request $request) {

        $check_items = array('token', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (!$request->user || !$request->user->profile)
            return $this->error(1004);

        $request->user->profile->avatar_url = url('/').$request->user->profile->avatar_url;
        $this->body['data']['user'] = $request->user;

        return $this->output($this->body);
    }


    public function update_profile(Request $request) {

        $check_items = array('token', 'username', 'gender', 'address');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        
        if (Input::get('gender') != '0' && Input::get('gender') != '1')
            return $this->error(1004); 

        if (Input::file('avatar') != null && Input::file('avatar')->isValid()){   
            $file = array('avatar' => Input::file('avatar'));
            $destinationPath = 'uploads'; // upload path
            $extension = Input::file('avatar')->getClientOriginalExtension(); // getting image extension
            $fileName = md5(Input::file('avatar')->getClientOriginalName().date('Y-m-d H:i:s')).'.'.$extension; // renameing image
            Input::file('avatar')->move($destinationPath, $fileName); // uploading file to given path
            $request->user->profile->avatar_url = '/'.$destinationPath.'/'.$fileName;
        } else {
            return $this->error(1004); 
        }

        try {
            $request->user->profile->name = Input::get('username');
            $request->user->profile->gender = Input::get('gender');
            $request->user->profile->address = Input::get('address');
            $request->user->profile->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

}
