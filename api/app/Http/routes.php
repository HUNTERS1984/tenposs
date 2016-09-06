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

Route::any('/', function () {
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
    Route::get('get_sig_test','TopController@get_sig_time_test');
    Route::get('list_app','TopController@list_app');
    // User
    Route::resource('user','UserController');

    Route::group(['middleware' => 'api.auth'], function () {
        Route::post('signout','AppUserController@signout');
        Route::post('set_push_key','AppUserController@set_push_key');
        Route::post('set_push_setting','AppUserController@set_push_setting');
        Route::get('profile','AppUserController@profile');
        Route::post('update_profile','AppUserController@update_profile');
    });
    Route::post('notification','TopController@notification');
});

Route::get('user1','UserController@index');
Route::get('test','TestController@index');


/*
 * Chat routing clients
 */

Route::group(array('prefix' => 'chat'), function() {
    
    Route::get('app/{app_id}',array('as'=>'admin.clients.chat','uses'=> 'ChatLineController@chatAdmin'));
    
    Route::any('bot', array('as'=>'line.bot','uses' => 'ChatLineController@index' ));
    Route::get('line/verifined/token/{mid}', array('as'=>'line.verifined.token','uses' => 'ChatLineController@verifinedToken' ));
    Route::get('verifined', array('as'=>'chat.authentication','uses' => 'ChatLineController@verifined' ));
    Route::get('login',array('as'=>'chat.login','uses' =>'ChatLineController@login'));
    Route::get('screen/{app_user_id}','ChatLineController@chatScreen');

    
});

/*
 * Admin routing
 */

Route::group(array('prefix' => 'admin','middlewareGroups' => ['web']), function() {
    Route::get('login', array('as'=>'admin.login','uses' => 'Admin\ClientsController@login' ));
    Route::post('login', array('as'=>'admin.login.post','uses' => 'Admin\ClientsController@login' ));
});

Route::group(array('prefix' => 'admin',
    'middlewareGroups' => ['web','auth'],
    'middleware' => ['role:admin,access_backend']), function()
{

     Route::get('/', array('as'=>'admin.home', function(){
        return view('admin.dashboard');
     } ));
    Route::get('/logout', array('as'=>'admin.logout','uses' => 'Admin\ClientsController@logout' ));

    Route::get('/clients', array('as'=>'admin.clients','uses' => 'Admin\ClientsController@index' ));
    Route::get('/clients/{user_id}/apps', array('as'=>'admin.clients.apps','uses' => 'Admin\AppsController@index' ));
    // Clients
    Route::get('/clients/{user_id}/apps/create', array('as'=>'admin.clients.apps.create','uses' => 'Admin\AppsController@create' ));
    Route::post('/clients/{user_id}/apps/create', array('as'=>'admin.clients.apps.store','uses' => 'Admin\AppsController@store' ));
    Route::get('/clients/{user_id}/apps/{app_id}/edit', array('as'=>'admin.clients.apps.edit','uses' => 'Admin\AppsController@edit' ));
    Route::post('/clients/{user_id}/apps/{app_id}/edit', array('as'=>'admin.clients.apps.update','uses' => 'Admin\AppsController@update' ));
    Route::get('/clients/{user_id}/apps/{app_id}/delete', array('as'=>'admin.clients.apps.delete','uses' => 'Admin\AppsController@delete' ));


});

//Route::get('/test', function() {
//    echo '<pre>';
////    dd(\App\Models\AppUser::with('userpushs')->where('id', 1)->get()->toArray());
////    echo \App\Models\AppUser::find(1)->userpushs()->get();
////    $_topRepository = \App\Repositories\Contracts\NotificationRepositoryInterface::class
////    print_r(\App\Repositories\El)
//});