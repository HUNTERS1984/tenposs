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
    Route::post('login','AppUserController@login');
    Route::post('setpushkey','AppUserController@setpushkey');
    Route::get('top','TopController@top');
    Route::get('appinfo','TopController@appinfo');
    Route::get('items','ItemController@index');
    Route::get('items/detail','ItemController@detail');
    Route::post('test','AppUserController@test');
    Route::get('news','NewController@index');
    Route::get('photo','PhotoController@index');
    Route::get('reserve','ReserveController@index');
    Route::get('coupon','CouponController@index');
});