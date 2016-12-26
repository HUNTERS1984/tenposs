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


Route::group(array('prefix' => 'api/v1'), function () {
    Route::post('signup', 'AppUserController@signup');
    Route::post('signin', 'AppUserController@signin');
    Route::post('social_login', 'AppUserController@social_login');

    Route::get('top', 'TopController@top');
    Route::get('appinfo', 'TopController@appinfo');
    Route::get('menu', 'ItemController@menu');
    Route::get('items', 'ItemController@items');
    Route::get('item_related', 'ItemController@item_related');
    Route::get('item_detail', 'ItemController@item_detail');
    Route::get('staff_categories', 'StaffController@staff_categories');
    Route::get('staff_detail', 'StaffController@staff_detail');
    Route::get('staffs', 'StaffController@staffs');
    Route::get('news', 'NewsController@index');
    Route::get('news_detail', 'NewsController@news_detail');
    Route::get('news_cat', 'NewsController@news_cat');
    Route::get('photo_cat', 'PhotoController@photo_cat');
    Route::get('photo', 'PhotoController@index');
    Route::get('reserve', 'ReserveController@index');
    Route::get('coupon', 'CouponController@index');
    Route::get('coupon_detail', 'CouponController@coupon_detail');
    Route::get('get_sig_test', 'TopController@get_sig_time_test');
    Route::get('list_app', 'TopController@list_app');
    Route::get('get_app_by_domain', 'AppUserController@get_app_by_domain');
    Route::get('get_data_web_notification', 'AppUserController@get_data_web_notification');
    Route::get('delete_data_web_notification', 'AppUserController@delete_data_web_notification');
    Route::get('share_get_code', 'AppUserController@share_get_code');
    Route::post('create_virtual_host', 'AppUserController@create_virtual_host');
    Route::get('app_secret_info', 'TopController@app_secret_info');
    // User
    Route::resource('user', 'UserController');

    Route::group(['middleware' => 'api.auth'], function () {
        Route::post('signout', 'AppUserController@signout');
        Route::post('set_push_key', 'AppUserController@set_push_key');
        Route::post('set_push_setting', 'AppUserController@set_push_setting');
        Route::get('profile', 'AppUserController@profile');
        Route::post('update_profile', 'AppUserController@update_profile');
        Route::post('social_profile', 'AppUserController@social_profile');
        Route::post('social_profile_cancel', 'AppUserController@social_profile_cancel');
        Route::get('get_push_setting', 'AppUserController@get_push_setting');
        Route::post('coupon_use', 'CouponController@coupon_use');
        Route::post('coupon_use_new', 'CouponController@coupon_use_new');
    });
    Route::post('notification', 'TopController@notification');
    Route::post('notification_app_id', 'TopController@notification_with_app_id');
    Route::post('notification_with_staffs', 'TopController@notification_with_staffs');
});

Route::get('user1', 'UserController@index');
Route::get('test', 'TestController@index');


/*
 * Admin routing
 */

Route::group(array('prefix' => 'admin', 'middlewareGroups' => ['web']), function () {
    Route::get('login', array('as' => 'admin.login', 'uses' => 'Admin\ClientsController@login'));
    Route::post('login', array('as' => 'admin.login.post', 'uses' => 'Admin\ClientsController@login'));
});

Route::group(array('prefix' => 'admin',
    'middlewareGroups' => ['web'],
    'middleware' => ['jwt.auth.custom']
), function () {

    Route::get('/', array('as' => 'admin.home', function () {
        return view('admin.dashboard');
    }));
    Route::get('/logout', array('as' => 'admin.logout', 'uses' => 'Admin\ClientsController@logout'));
    
    // Clients
    Route::get('/clients', array('as' => 'admin.clients', 'uses' => 'Admin\ClientsController@index'));
    Route::get('/clients/{user_id}', array('as' => 'admin.clients.show', 'uses' => 'Admin\ClientsController@show'));
    Route::get('/clients/{user_id}/apps', array('as' => 'admin.clients.apps', 'uses' => 'Admin\AppsController@index'));
    Route::post('/clients/approved/process', array('as' => 'admin.approved.users.process', 'uses' => 'Admin\ClientsController@approvedUsersProcess'));

    // Clients/Apps
    Route::get('/clients/{user_id}/apps/create', array('as' => 'admin.clients.apps.create', 'uses' => 'Admin\AppsController@create'));
    Route::post('/clients/{user_id}/apps/create', array('as' => 'admin.clients.apps.store', 'uses' => 'Admin\AppsController@store'));
    Route::get('/clients/{user_id}/apps/{app_id}/edit', array('as' => 'admin.clients.apps.edit', 'uses' => 'Admin\AppsController@edit'));
    Route::post('/clients/{user_id}/apps/{app_id}/edit', array('as' => 'admin.clients.apps.update', 'uses' => 'Admin\AppsController@update'));
    Route::get('/clients/{user_id}/apps/{app_id}/delete', array('as' => 'admin.clients.apps.delete', 'uses' => 'Admin\AppsController@delete'));
    Route::get('/clients/{user_id}/apps/{app_id}/setting', array('as' => 'admin.clients.apps.setting', 'uses' => 'Admin\AppsController@setting'));
    Route::post('/clients/{user_id}/apps/{app_id}/upload', array('as' => 'admin.clients.apps.upload', 'uses' => 'Admin\AppsController@upload'));
    Route::post('/clients/{user_id}/apps/{app_id}/upload_web', array('as' => 'admin.clients.apps.uploadweb', 'uses' => 'Admin\AppsController@upload_web'));

    // Clients/LINEBot
    Route::get('/clients/{user_id}/apps/{app_id}/line-bot', array('as' => 'admin.clients.bot.setting', 'uses' => 'Admin\ClientsController@configLineBOT'));
    Route::post('/clients/{user_id}/apps/{app_id}/line-bot', array('as' => 'admin.clients.bot.setting.save', 'uses' => 'Admin\ClientsController@configLineBOTSave'));

    Route::get('/setting', array('as' => 'admin.setting', 'uses' => 'Admin\SettingController@setting'));
    


});


Route::group(array('prefix' => 'api/v2'), function () {
    Route::post('signup', 'AppUserController@v2_signup');
    Route::post('signup_social', 'AppUserController@v2_signup_social');
    Route::get('coupon_detail', 'CouponController@v2_coupon_detail');
    Route::get('get_app_user', 'AppUserController@get_auth_user_from_app_user_id');

    Route::group(['middleware' => 'api.auth.jwt'], function () {
        Route::get('profile', 'AppUserController@v2_profile');
        Route::get('get_invite_code', 'AppUserController@v2_get_invite_code');
        Route::post('update_profile', 'AppUserController@v2_update_profile');
        Route::post('social_profile', 'AppUserController@v2_social_profile');
        Route::post('social_profile_cancel', 'AppUserController@v2_social_profile_cancel');
        Route::post('coupon_use', 'CouponController@v2_coupon_use');
        Route::post('coupon_use_new', 'CouponController@v2_coupon_use_new');
        Route::post('update_profile_social_signup', 'AppUserController@v2_update_profile_from_social_signup');
        Route::get('coupon_login', 'CouponController@index_login');
        Route::get('coupon_detail_login', 'CouponController@v2_coupon_detail_login');
        Route::get('list_user', 'AppUserController@get_list_user');
        Route::post('remove_user', 'AppUserController@v2_remove_user');
        Route::post('update_last_login', 'AppUserController@v2_update_last_login');
    });
});



//Route::get('/test', function() {
//    echo '<pre>';
//    dd(\App\Models\AppUser::with('userpushs')->where('id', 1)->get()->toArray());
////    echo \App\Models\AppUser::find(1)->userpushs()->get();
////    $_topRepository = \App\Repositories\Contracts\NotificationRepositoryInterface::class
////    print_r(\App\Repositories\El)
//});