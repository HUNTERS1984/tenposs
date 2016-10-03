<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MobileController@index');

Route::get('/sign-in', ['as'=> 'login', 'uses' => 'MobileController@login']);

Route::get('/test', function () {
    $arr = array('app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    $secret_key = "ádsadsadsa"; //lay tu app_app_secret
    return \App\Utils\HttpRequestUtil::getInstance()->get_data('appinfo', $arr,$secret_key);

    $arr_post = array('email' => 'bangnk@a.a',
        'password' => '123456',
        'app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    $secret_key = "ádsadsadsa"; //lay tu app_app_secret
    return \App\Utils\HttpRequestUtil::getInstance()->post_data('signin',$arr_post,$secret_key);
});
