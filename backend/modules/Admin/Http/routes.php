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

Route::group(['prefix' => 'admin'], function() {
	// Authentication Routes...
    $this->get('login',['middleware'=>'IsLogin','uses'=> 'Auth\AuthController@showLoginForm']);
    $this->post('login', 'Auth\AuthController@login');
    $this->get('logout',['middleware'=>'auth'],'Auth\AuthController@logout');

    // Registration Routes...
    $this->get('register',['middleware'=>'isLogin','as'=>'admin.register','uses'=>'Auth\AuthController@showRegistrationForm'] );
    $this->post('register',['middleware'=>'isLogin','as'=>'admin.postRegister','uses'=>'Auth\AuthController@register']);

    // Password Reset Routes...
    $this->get('password/reset/{token?}',['middleware'=>'auth','as'=>'admin.resetPassword','uses'=>'Auth\PasswordController@showResetForm']);
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    Route::group(['middleware'=>['auth']],function(){
        Route::get('top',['as'=>'admin.top','uses'=>'AdminController@top']);
        Route::get('global',['as'=>'admin.global','uses'=>'AdminController@globalpage']);
        Route::get('test-ga',['as'=>'admin.ga','uses'=>'AdminController@getAnalytic']);
        // NEWS
        Route::resource('news','NewsController');
        // MENUS
        Route::get('menus/view_more',['as'=>'admin.menus.view_more','uses'=>'MenusController@view_more'] );
        Route::get('menus/nextcat',['as'=>'admin.menus.nextcat','uses'=>'MenusController@nextcat'] );
        Route::get('menus/nextpreview',['as'=>'admin.menus.nextpreview','uses'=>'MenusController@nextpreview'] );
        Route::post('menus/storeitem',['as'=>'admin.menus.storeitem','uses'=>'MenusController@storeitem'] );
        Route::resource('menus','MenusController');
        // PHOTO CATS
        Route::get('photo-cate/view_more',['as'=>'admin.photo-cate.view_more','uses'=>'PhotoCatController@view_more'] );
        Route::post('photo-cate/storephoto',['as'=>'admin.photo-cate.storephoto','uses'=>'PhotoCatController@storephoto'] );
        Route::get('photo-cate/nextcat',['as'=>'admin.photo-cate.nextcat','uses'=>'PhotoCatController@nextcat'] );
        Route::get('photo-cate/nextpreview',['as'=>'admin.photo-cate.nextpreview','uses'=>'PhotoCatController@nextpreview'] );
        Route::resource('photo-cate','PhotoCatController');
        // STAFF
        Route::resource('staff','StaffController');

        // COUPON
        Route::get('coupon/view_more',['as'=>'admin.coupon.view_more','uses'=>'CouponController@view_more']);
        Route::get('coupon/approve/{coupon_id}/{post_id}',['as'=>'admin.coupon.approve','uses'=>'CouponController@approve']);
        Route::get('coupon/unapprove/{coupon_id}/{post_id}',['as'=>'admin.coupon.unapprove','uses'=>'CouponController@unapprove']);
        Route::post('coupon/store_type',['as'=>'admin.coupon.store_type','uses'=>'CouponController@store_type'] );
        Route::resource('coupon','CouponController');
        
    });
});

