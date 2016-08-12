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

Route::get('/', function () {
    return view('welcome');
});


Route::group(array('prefix' => 'api/v1'), function()
{
    Route::post('signup','AppUserController@signup');
    Route::post('signin','AppUserController@signin');
    Route::post('social_login','AppUserController@social_login');
    
    Route::get('top','TopController@top');
    Route::get('appinfo','TopController@appinfo');
    Route::get('menu','ItemController@menu');
    Route::get('items','ItemController@items');
    Route::get('news','NewsController@index');
    Route::get('photo_cat','PhotoController@photo_cat');
    Route::get('photo','PhotoController@index');
    Route::get('reserve','ReserveController@index');
    Route::get('coupon','CouponController@index');

    // User
    Route::resource('user','UserController');

    Route::group(['middleware' => 'api.auth'], function () {
        Route::post('signout','AppUserController@signout');
        Route::post('set_push_key','AppUserController@set_push_key');
        Route::post('set_push_setting','AppUserController@set_push_setting');
        Route::get('profile','AppUserController@profile');
        Route::post('update_profile','AppUserController@update_profile');
    });

});