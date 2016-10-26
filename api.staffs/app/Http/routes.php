<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$app->post('/login', 'Auth\AuthController@postLogin');
$app->get('/token', 'Auth\AuthController@token');

$app->group(['middleware' => 'jwt.auth'], function ($app) {
    $app->get('/', function () use ($app) {
        return [
            'success' => [
                'app' => $app->version(),
            ],
        ];
    });

    $app->get('/user', function () use ($app) {
        return [
            'success' => [
                'user' => JWTAuth::parseToken()->authenticate(),
            ],
        ];
    });

    $app->get('/refresh', 'App\Http\Controllers\Auth\AuthController@getRefresh');
    $app->delete('/invalidate', 'App\Http\Controllers\Auth\AuthController@deleteInvalidate');

    $app->post('/set_push_key', 'App\Http\Controllers\StaffController@set_push_key');
    $app->post('/coupon_accept', 'App\Http\Controllers\StaffController@coupon_accept');
    $app->get('/list_user_request', 'App\Http\Controllers\StaffController@list_user_request');
});
