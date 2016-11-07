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

$app->post('/auth/social_login', 'Auth\AuthController@socialLogin');
$app->post('/auth/login', 'Auth\AuthController@postLogin');
$app->post('/auth/register', 'UserController@register');
$app->post('/auth/register_with_active', 'UserController@register_with_active');
$app->post('/auth/activate_with_code', 'UserController@activate_with_code');
$app->get('/auth/demo_token', 'Auth\AuthController@demo_token');

$app->group(['middleware' => 'jwt.auth'], function ($app) {
    $app->get('/auth/refresh', 'App\Http\Controllers\Auth\AuthController@getRefresh');
    $app->delete('/auth/invalidate', 'App\Http\Controllers\Auth\AuthController@deleteInvalidate');


    $app->get('/userlist', 'App\Http\Controllers\UserController@userlist');
    $app->get('/approvelist', 'App\Http\Controllers\UserController@approvelist');
    $app->get('/profile', 'App\Http\Controllers\UserController@profile');
    $app->post('/activate', 'App\Http\Controllers\UserController@activate');
    $app->get('/user', 'App\Http\Controllers\UserController@profile');
    $app->post('/user/delete', 'App\Http\Controllers\UserController@delete');
});


$app->group(array('prefix' => 'v1', 'middleware' => 'BasicAuth'), function ($app) {
    $app->get('/test', 'App\Http\Controllers\UserV1Controller@test');
    $app->post('/auth/login', 'App\Http\Controllers\Auth\AuthV1Controller@postLogin');
    $app->get('/auth/access_token/{id_code}/{refresh_token}', 'App\Http\Controllers\Auth\AuthV1Controller@access_token');
});

$app->group(array('prefix' => 'v1', 'middleware' => 'jwt.auth'), function ($app) {
    $app->get('/profile', 'UserV1Controller@profile');

});
$app->group(['middleware' => 'jwt.refresh'], function ($app) {

});