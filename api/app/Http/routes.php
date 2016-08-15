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

    Route::get('top/token/{token?}/time/{time?}/sig/{sig?}','TopController@top');
    Route::get('appinfo/storeid/{store_id?}/token/{token?}/time/{time?}/sig/{sig?}','TopController@appinfo');


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

    // User
    Route::resource('user','UserController');
});

Route::group(array('prefix' => 'admin','middlewareGroups' => ['web']), function()
{
     Route::get('/', array('as'=>'admin.home', function(){
        return 'Welcome to admin board';
     } ));


    Route::get('/clients', array('as'=>'admin.clients','uses' => 'Admin\ClientsController@index' ));
    Route::get('/clients/{user_id}/apps', array('as'=>'admin.clients.apps','uses' => 'Admin\AppsController@index' ));
    Route::get('/clients/{user_id}/apps/create', array('as'=>'admin.clients.apps.create','uses' => 'Admin\AppsController@create' ));
    Route::post('/clients/{user_id}/apps/create', array('as'=>'admin.clients.apps.store','uses' => 'Admin\AppsController@store' ));
    Route::get('/clients/{user_id}/apps/{app_id}/edit', array('as'=>'admin.clients.apps.edit','uses' => 'Admin\AppsController@edit' ));
    Route::get('/clients/{user_id}/apps/{app_id}/delete', array('as'=>'admin.clients.apps.delete','uses' => 'Admin\AppsController@delete' ));


});