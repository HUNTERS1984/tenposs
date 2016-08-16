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
        Route::post('profile','AppUserController@profile');
        Route::post('update_profile','AppUserController@update_profile');
    });

});

Route::get('user1','UserController@index');
Route::get('test','TestController@index');

/*
 * Admin routing
 */

Route::group(array('prefix' => 'admin','middlewareGroups' => ['web']), function() {
    Route::get('login', array('as'=>'admin.login','uses' => 'Admin\ClientsController@login' ));
});

Route::group(array('prefix' => 'admin','middlewareGroups' => ['web'],'middleware' => 'auth'), function()
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