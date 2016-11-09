<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'admin1'], function () {
    Route::get('/', function(){ return 'Welcome'; });
    // Authentication Routes...
    //$this->get('login', ['middleware' => 'IsLogin', 'uses' => 'Auth\AuthController@showLoginForm']);
    //$this->post('login', 'Auth\AuthController@postLogin');
    // $this->get('logout', 'Auth\AuthController@logout');
    $this->get('waiting', 'AdminController@waiting');

    // Registration Routes...
    //$this->get('register', ['middleware' => 'IsLogin', 'as' => 'admin.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
    //$this->post('register', ['middleware' => 'IsLogin', 'as' => 'admin.postRegister', 'uses' => 'Auth\AuthController@register']);

    // Password Reset Routes...
    //$this->get('password/reset/{token?}', ['middleware' => 'auth', 'as' => 'admin.resetPassword', 'uses' => 'Auth\PasswordController@showResetForm']);
    //$this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    //$this->post('password/reset', 'Auth\PasswordController@reset');

    Route::group(['middleware' => ['jwt.auth.custom']], function () {
        
        Route::get('top', ['as' => 'admin.top', 'uses' => 'AdminController@top']);
        Route::post('top/store', ['as' => 'admin.top.store', 'uses' => 'AdminController@topstore']);
        Route::post('upload', ['as' => 'admin.upload', 'uses' => 'AdminController@upload']);
        Route::get('upload', ['as' => 'admin.upload', 'uses' => 'AdminController@upload']);
        Route::delete('upload/delete', ['as' => 'admin.upload.delete', 'uses' => 'AdminController@uploaddelete']);
        Route::get('global', ['as' => 'admin.global', 'uses' => 'AdminController@globalpage']);
        Route::post('global', ['as' => 'admin.global.store', 'uses' => 'AdminController@globalstore']);
        Route::get('test-ga', ['as' => 'admin.ga', 'uses' => 'AdminController@getAnalytic']);
        // NEWS
        Route::get('news/nextcat', ['as' => 'admin.news.nextcat', 'uses' => 'NewsController@nextcat']);
        Route::get('news/nextpreview', ['as' => 'admin.news.nextpreview', 'uses' => 'NewsController@nextpreview']);
        Route::post('news/storeCat', ['as' => 'admin.news.storeCat', 'uses' => 'NewsController@storeCat']);
        Route::resource('news', 'NewsController');
        // MENUS
        Route::get('menus/view_more', ['as' => 'admin.menus.view_more', 'uses' => 'MenusController@view_more']);
        Route::get('menus/nextcat', ['as' => 'admin.menus.nextcat', 'uses' => 'MenusController@nextcat']);
        Route::get('menus/nextpreview', ['as' => 'admin.menus.nextpreview', 'uses' => 'MenusController@nextpreview']);
        Route::post('menus/storeitem', ['as' => 'admin.menus.storeitem', 'uses' => 'MenusController@storeitem']);
        Route::post('menus/storeMenu', ['as' => 'admin.menus.storeMenu', 'uses' => 'MenusController@storeMenu']);
        Route::resource('menus', 'MenusController');
        // PHOTO CATS
        Route::get('photo-cate/view_more', ['as' => 'admin.photo-cate.view_more', 'uses' => 'PhotoCatController@view_more']);
        Route::post('photo-cate/storephoto', ['as' => 'admin.photo-cate.storephoto', 'uses' => 'PhotoCatController@storephoto']);
        Route::get('photo-cate/nextcat', ['as' => 'admin.photo-cate.nextcat', 'uses' => 'PhotoCatController@nextcat']);
        Route::get('photo-cate/nextpreview', ['as' => 'admin.photo-cate.nextpreview', 'uses' => 'PhotoCatController@nextpreview']);
        Route::resource('photo-cate', 'PhotoCatController');
        // STAFF

        Route::get('staff/view_more', ['as' => 'admin.staff.view_more', 'uses' => 'StaffController@view_more']);
        Route::get('staff/nextcat', ['as' => 'admin.staff.nextcat', 'uses' => 'StaffController@nextcat']);
        Route::get('staff/nextpreview', ['as' => 'admin.staff.nextpreview', 'uses' => 'StaffController@nextpreview']);
        Route::post('staff/storestaff', ['as' => 'admin.staff.storestaff', 'uses' => 'StaffController@storestaff']);
        Route::post('staff/storeCat', ['as' => 'admin.staff.storeCat', 'uses' => 'StaffController@storeCat']);
        Route::resource('staff', 'StaffController');
        // COUPON
        Route::get('coupon/view_more', ['as' => 'admin.coupon.view_more', 'uses' => 'CouponController@view_more']);
        Route::get('coupon/approve/{coupon_id}/{post_id}', ['as' => 'admin.coupon.approve', 'uses' => 'CouponController@approve']);
        Route::get('coupon/unapprove/{coupon_id}/{post_id}', ['as' => 'admin.coupon.unapprove', 'uses' => 'CouponController@unapprove']);
        Route::post('coupon/store_type', ['as' => 'admin.coupon.store_type', 'uses' => 'CouponController@store_type']);
        Route::resource('coupon', 'CouponController');

        // Categries
        Route::delete('category/deletetype/{id}/{type}', ['as' => 'admin.category.deletetype', 'uses' => 'CategoriesController@destroy']);
        Route::get('category/create', ['as' => 'admin.category.create', 'uses' => 'CategoriesController@create']);
        Route::get('category/store', ['as' => 'admin.category.store', 'uses' => 'CategoriesController@store']);
        Route::resource('category', 'CategoriesController');
        //Reserves
        Route::resource('reserve', 'ReservesController');


    });
});


// CHAT
/*
Route::group(array('prefix' => 'chat'), function () {
    Route::get('line', array('as' => 'admin.clients.chat', 'uses' => 'ChatLineController@chatAdmin'));
    Route::post('bot', array('as' => 'line.bot', 'uses' => 'ChatLineController@index'));
    Route::get('line/verifined/token/{mid}', array('as' => 'line.verifined.token', 'uses' => 'ChatLineController@verifinedToken'));
    Route::get('verifined', array('as' => 'chat.authentication', 'uses' => 'ChatLineController@verifined'));
    Route::get('login', array('as' => 'chat.login', 'uses' => 'ChatLineController@login'));
    Route::get('screen/{app_user_id}', 'ChatLineController@chatScreen');
    Route::post('contact/seacrch', array('as' => 'chat.seach.contact', 'uses' => 'ChatLineController@searchContact'));
});*/

Route::get('coupon/use/code/{user_id}/{coupon_id}/{code}/{sig}', array('as' => 'coupon.use.code', 'uses' => 'CouponController@coupon_use_code_view'));
Route::post('coupon/use/code/approve', array('as' => 'coupon.use.code.approve', 'uses' => 'CouponController@coupon_use_code_approve'));