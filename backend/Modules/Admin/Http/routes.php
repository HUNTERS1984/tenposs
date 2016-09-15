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
    $this->get('logout','Auth\AuthController@logout');
    $this->get('waiting','AdminController@waiting');

    // Registration Routes...
    $this->get('register',['middleware'=>'IsLogin','as'=>'admin.register','uses'=>'Auth\AuthController@showRegistrationForm'] );
    $this->post('register',['middleware'=>'IsLogin','as'=>'admin.postRegister','uses'=>'Auth\AuthController@register']);

    // Password Reset Routes...
    $this->get('password/reset/{token?}',['middleware'=>'auth','as'=>'admin.resetPassword','uses'=>'Auth\PasswordController@showResetForm']);
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    Route::group(['middleware'=>['auth']],function(){
        Route::get('top',['as'=>'admin.top','uses'=>'AdminController@top']);
        Route::post('top/store',['as'=>'admin.top.store','uses'=>'AdminController@topstore']);
        Route::post('upload',['as'=>'admin.upload','uses'=>'AdminController@upload']);
        Route::get('upload',['as'=>'admin.upload','uses'=>'AdminController@upload']);
        Route::delete('upload/delete',['as'=>'admin.upload.delete','uses'=>'AdminController@uploaddelete']);
        Route::get('global',['as'=>'admin.global','uses'=>'AdminController@globalpage']);
        Route::post('global/store',['as'=>'admin.global.store','uses'=>'AdminController@globalstore']);
        Route::get('test-ga',['as'=>'admin.ga','uses'=>'AdminController@getAnalytic']);
        // NEWS
        Route::resource('news','NewsController');
        // MENUS
        Route::get('menus/view_more',['as'=>'admin.menus.view_more','uses'=>'MenusController@view_more'] );
        Route::get('menus/nextcat',['as'=>'admin.menus.nextcat','uses'=>'MenusController@nextcat'] );
        Route::get('menus/nextpreview',['as'=>'admin.menus.nextpreview','uses'=>'MenusController@nextpreview'] );
        Route::post('menus/storeitem',['as'=>'admin.menus.storeitem','uses'=>'MenusController@storeitem'] );
        Route::post('menus/storeMenu',['as'=>'admin.menus.storeMenu','uses'=>'MenusController@storeMenu']);
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


// CHAT

Route::group(array('prefix' => 'chat'), function() {
    Route::get('line',array('as'=>'admin.clients.chat','uses'=> 'ChatLineController@chatAdmin'));
    Route::post('bot', array('as'=>'line.bot','uses' => 'ChatLineController@index' ));
    Route::get('line/verifined/token/{mid}', array('as'=>'line.verifined.token','uses' => 'ChatLineController@verifinedToken' ));
    Route::get('verifined', array('as'=>'chat.authentication','uses' => 'ChatLineController@verifined' ));
    Route::get('login',array('as'=>'chat.login','uses' =>'ChatLineController@login'));
    Route::get('screen/{app_user_id}','ChatLineController@chatScreen');
});