<?php

namespace App\Http\Controllers\Auth;

use App\UserRefreshToken;
use App\Utils\HttpUtils;
use App\Utils\PseudoCrypt;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Namshi\JOSE\JWT;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;
use App\User;
use Illuminate\Support\Facades\Input;
use Twitter;
use DB;
use Bican\Roles\Models\Role;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Token;

class AuthV1Controller extends Controller
{
    public function verify_facebook_token($token)
    {
        try {
            $graph_url = "https://graph.facebook.com/me?access_token=" . $token;
            $json = @file_get_contents($graph_url);
            if ($json === false)
                return false;

            return $json;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function verify_twitter_token($token, $secret)
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
            if (!$credentials)
                return false;


            return $credentials;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function socialLogin(Request $request)
    {
        $facebook_status = 0;
        $twitter_status = 0;
        $email = "";
        $password = "";

        if (Input::get('social_type') == 1) {
            $check_items = array('social_token');
            $facebook_status = 1;
            $result = $this->verify_facebook_token(Input::get('social_token'));
            if ($result == false) {
                return $this->error(9998);
            }
            $email = $result['id'] . '@fb.com';
            $password = Input::get('social_token');
        } else if (Input::get('social_type') == 2) {
            $check_items = array('social_token', 'social_secret');
            $twitter_status = 1;
            $result = $this->verify_twitter_token(Input::get('social_token'), Input::get('social_secret'));
            if ($result == false) {
                return $this->error(9998);
            }

            $email = $result->id . '@tw.com';
            $password = Input::get('social_token');
        } else {
            return $this->error(1004);
        }

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;


        try {
            $user = User::where('email', $email)->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }

        if (!$user) {
            try {
                DB::beginTransaction();
                $user = new User();
                $user->email = $email;
                $user->password = app('hash')->make($password);
                $user->save();

                $role = Role::whereSlug('user')->first();
                $user->attachRole($role);

                DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                dd($e);
                return $this->error(9999);
            }
        }

        $user = User::whereEmail($email)->with('roles')->first();

        $credentials = array();
        $credentials['email'] = $email;
        $credentials['password'] = $password;

        if ($user && $user->roles && count($user->roles) > 0 && $token = JWTAuth::attempt($credentials, ['role' => $user->roles[0]->slug])) {
            $this->body['data'] = $token;
            return $this->output($this->body);
        } else {
            return $this->error(9995);
        }
    }


    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);
        } catch (HttpResponseException $e) {
            return $this->error(9995);
        }

        $credentials = $this->getCredentials($request);

        try {
            $user = User::whereEmail(Input::get('email'))->with('roles')->first();
            if ($user->active != 1)
                return $this->error(99950);
            // Attempt to verify the credentials and create a token for the user
            if ($user && $user->roles && count($user->roles) > 0 && $token = JWTAuth::attempt($credentials, ['role' => $user->roles[0]->slug, 'id' => $user->id])) {
                $this->body['data']['token'] = (string)$token;
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
        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
            return $this->error(9999);
        }


    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Invalidate a token.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteInvalidate()
    {
        $token = JWTAuth::parseToken();

        $token->invalidate();

        return $this->output($this->body);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRefresh()
    {
        $token = JWTAuth::parseToken();

        $newToken = $token->refresh();
        $this->body['data'] = $newToken;

        return $this->output($this->body);
    }

    public function access_token($id_code, $refresh_token, Request $request)
    {
        try {
            $refresh = UserRefreshToken::where('user_id_code', $id_code)
                ->where('refresh_token', $refresh_token)->first();
            if (count($refresh) > 0) {
                $user = User::whereId($refresh->user_id)->first();
                if (count($user) > 0) {
                    $token = JWTAuth::fromUser($user, ['role' => $user->roles[0]->slug, 'id' => $user->id]);
                    $this->body['data']['token'] = $token;
                    $refresh_token = md5($user->id . Carbon::now()->timestamp);
                    $this->body['data']['refresh_token'] = $refresh_token;
                    $this->body['data']['access_refresh_token_href'] = HttpUtils::get_refresh_token_url($request, $id_code, $refresh_token);
                    //update refresh token
                    $refresh->refresh_token = $refresh_token;
                    $refresh->user_id_code = $id_code;
                    $refresh->time_expire = Carbon::now()->addMinutes(Config::get('jwt.refresh_ttl'))->timestamp;
                    $refresh->save();
                    return $this->output($this->body);
                } else
                    return $this->error(99953);
            } else {
                return $this->error(99954);
            }
            print_r($refresh);
            die;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            return $this->error(9999);
        }
        return $this->output($this->body);
    }
}