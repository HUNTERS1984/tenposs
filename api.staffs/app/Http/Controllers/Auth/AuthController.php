<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
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
//            return response()->json([
//                'error' => [
//                    'message' => 'invalid_auth',
//                    'status_code' => IlluminateResponse::HTTP_BAD_REQUEST,
//                ],
//            ], IlluminateResponse::HTTP_BAD_REQUEST);
            return $this->error_status(1002, IlluminateResponse::HTTP_BAD_REQUEST);
        }


        $credentials = $this->getCredentials($request);


        try {
            // Attempt to verify the credentials and create a token for the user
//            if (!$token = JWTAuth::attempt($credentials)) {
//
//                return response()->json([
//                    'error' => [
//                        'message' => 'invalid_credentials',
//                    ],
//                ], IlluminateResponse::HTTP_UNAUTHORIZED);
//            }
            $token = '';
            if (Auth::attempt($credentials)) {
                $app_info = DB::table('apps')->select('id', 'name', 'app_app_id', 'app_app_secret')
                    ->where('user_id', Auth::user()->id)->get();
                if (count($app_info) > 0) {
                    $app_info[0]->staff_id = Auth::user()->id;
                    $data = array('data' => $app_info[0]);
                    $token = JWTAuth::fromUser(Auth::user(), $data);
                }
            } else {
//                return response()->json([
//                    'error' => [
//                        'message' => 'invalid_credentials',
//                    ],
//                ], IlluminateResponse::HTTP_UNAUTHORIZED);
                return $this->error_status(7100, IlluminateResponse::HTTP_UNAUTHORIZED);
            }

        } catch (JWTException $e) {
            // Something went wrong whilst attempting to encode the token
//            return response()->json([
//                'error' => [
//                    'message' => 'could_not_create_token',
//                ],
//            ], IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);
            return $this->error_status(10018, IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        // All good so return the token
        $this->body['data']['token'] = $token;
        return $this->output($this->body, IlluminateResponse::HTTP_OK);
//        return response()->json([
//            'success' => [
//                'message' => 'token_generated',
//                'token' => $token,
//            ]
//        ]);
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
        return $this->output($this->body, IlluminateResponse::HTTP_OK);
//        return ['success' => 'token_invalidated'];
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
        $this->body['data']['token'] = $newToken;
        return $this->output($this->body, IlluminateResponse::HTTP_OK);
//        return ['success' => 'token_refreshed', 'token' => $newToken];
    }

    public function token()
    {
        $token = JWTAuth::getToken();
        if (!$token) {
//            throw new BadRequestHttpException('Token not provided');
            return $this->error_status(11002, IlluminateResponse::HTTP_BAD_REQUEST);
        }
        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
//            throw new TokenInvalidException('The token is invalid');
            return $this->error_status(10010, IlluminateResponse::HTTP_OK);
        }
        $this->body['data']['token'] = $token;
        return $this->output($this->body, IlluminateResponse::HTTP_OK);
//        return ['success' => 'token_refreshed', 'token' => $token];
    }
}
