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


Route::get('/test', function () {
//    $arr = array('item_id' => 2,
//        'app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
//
//    return \App\Utils\HttpRequestUtil::getInstance()->get_data('appinfo', $arr);

    $arr_post = array('email' => 'bangnk@a.a',
        'password' => '123456',
        'app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    return \App\Utils\HttpRequestUtil::getInstance()->post_data('signin',$arr_post);
});
