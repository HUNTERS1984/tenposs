<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Mockery\CountValidator\Exception;

class AppUserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {

        try {
            $statusCode = 1000;
            $message = 'OK';
            $response = [

            ];
            $type = $this->request['type'];
            if (!empty($type)) {
                switch ($type) {
                    case 'email': { //login email
                        $email = $this->request['email'];
                        $password = $this->request['password'];
                        //process check login and get info of user
                        $profile = array(
                            'user_profile_id' => 1,
                            'name' => 'TenPoss Email',
                            'gender' => 1,
                            'avatar_url' => 'avatar.jpg',
                            'facebook_status' => 0,
                            'twitter_status' => 0,
                            'instagram_status' => 0
                        );
                        $data = array(
                            'profile' => $profile,
                            'token' => '7aef1eea1f967d7f8fbcb8cbe4639dd0',
                            'app_id' => 1,
                            'login_type' => 'email'
                        );
                        $response = array('code' => $statusCode,
                            'message' => $message,
                            'data' => $data);
                        break;
                    }
                    case 'social': {
                        $socialId = $this->request['social_id'];
                        $socialType = $this->request['social_type'];
                        $socialToken = $this->request['social_token'];
                        //process check login and get info of user
                        $profile = array(
                            'user_profile_id' => 2,
                            'name' => 'TenPoss Social',
                            'gender' => 1,
                            'avatar_url' => 'avatar_social.jpg',
                            'facebook_status' => 1,
                            'twitter_status' => 0,
                            'instagram_status' => 0
                        );
                        $data = array(
                            'profile' => $profile,
                            'token' => '7aef1eea1f967d7f8fbcb8cbe4639dd0',
                            'app_id' => 1,
                            'login_type' => 'social'
                        );
                        $response = array('code' => $statusCode,
                            'message' => $message,
                            'data' => $data);
                        break;
                    }
                    default:
                        break;
                }
            }
        } catch (Exception $e) {
            $statusCode = 1005;
            $message = 'Unknown error';
            $response = array(
                'code' => $statusCode,
                'message' => $message,
                'data' => []
            );
        } finally {
            return response()->json($response);
        }
    }
}
