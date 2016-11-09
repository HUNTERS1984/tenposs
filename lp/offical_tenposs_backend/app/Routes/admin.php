<?php

Route::group(['prefix' => 'admin', 'middleware' => ['jwt.auth.custom'] ], function(){
	Route::get('/',['as' => 'admin.client.dashboard', 'uses' => 'Admin\AdminController@dashboard' ] );	
    Route::get('top',['as' => 'admin.client.top', 'uses' => 'Admin\AdminController@top' ] );
    Route::post('top', ['as' => 'admin.client.top.store', 'uses' => 'Admin\AdminController@topstore']);
    
    Route::get('global',['as' => 'admin.client.global', 'uses' => 'Admin\AdminController@globalpage' ] );
    Route::post('global', ['as' => 'admin.client.global.store', 'uses' => 'Admin\AdminController@globalstore']);
    // NEWS
    Route::get('news/nextcat', ['as' => 'admin.news.nextcat', 'uses' => 'Admin\NewsController@nextcat']);
    Route::get('news/nextpreview', ['as' => 'admin.news.nextpreview', 'uses' => 'Admin\NewsController@nextpreview']);
    Route::post('news/storeCat', ['as' => 'admin.news.storeCat', 'uses' => 'Admin\NewsController@storeCat']);
    Route::resource('news', 'Admin\NewsController');
    
    // MENUS
    Route::get('menus/view_more', ['as' => 'admin.menus.view_more', 'uses' => 'Admin\MenusController@view_more']);
    Route::get('menus/nextcat', ['as' => 'admin.menus.nextcat', 'uses' => 'Admin\MenusController@nextcat']);
    Route::get('menus/nextpreview', ['as' => 'admin.menus.nextpreview', 'uses' => 'Admin\MenusController@nextpreview']);
    Route::post('menus/storeitem', ['as' => 'admin.menus.storeitem', 'uses' => 'Admin\MenusController@storeitem']);
    Route::post('menus/storeMenu', ['as' => 'admin.menus.storeMenu', 'uses' => 'Admin\MenusController@storeMenu']);
    Route::resource('menus', 'Admin\MenusController');
    // PHOTO CATS
    Route::get('photo-cate/view_more', ['as' => 'admin.photo-cate.view_more', 'uses' => 'Admin\PhotoCatController@view_more']);
    Route::post('photo-cate/storephoto', ['as' => 'admin.photo-cate.storephoto', 'uses' => 'Admin\PhotoCatController@storephoto']);
    Route::get('photo-cate/nextcat', ['as' => 'admin.photo-cate.nextcat', 'uses' => 'Admin\PhotoCatController@nextcat']);
    Route::get('photo-cate/nextpreview', ['as' => 'admin.photo-cate.nextpreview', 'uses' => 'Admin\PhotoCatController@nextpreview']);
    Route::resource('photo-cate', 'Admin\PhotoCatController');
    // STAFF
    Route::get('staff/view_more', ['as' => 'admin.staff.view_more', 'uses' => 'Admin\StaffController@view_more']);
    Route::get('staff/nextcat', ['as' => 'admin.staff.nextcat', 'uses' => 'Admin\StaffController@nextcat']);
    Route::get('staff/nextpreview', ['as' => 'admin.staff.nextpreview', 'uses' => 'Admin\StaffController@nextpreview']);
    Route::post('staff/storestaff', ['as' => 'admin.staff.storestaff', 'uses' => 'Admin\StaffController@storestaff']);
    Route::post('staff/storeCat', ['as' => 'admin.staff.storeCat', 'uses' => 'Admin\StaffController@storeCat']);
    Route::get('staff/delete/{id}', ['as' => 'admin.staff.delete', 'uses' => 'Admin\StaffController@delete']);
    Route::resource('staff', 'Admin\StaffController');
    // COUPON
    Route::get('coupon/view_more', ['as' => 'admin.coupon.view_more', 'uses' => 'Admin\CouponController@view_more']);
    Route::get('coupon/approve/{coupon_id}/{post_id}', ['as' => 'admin.coupon.approve', 'uses' => 'Admin\CouponController@approve']);
    Route::get('coupon/unapprove/{coupon_id}/{post_id}', ['as' => 'admin.coupon.unapprove', 'uses' => 'Admin\CouponController@unapprove']);
    Route::post('coupon/store_type', ['as' => 'admin.coupon.store_type', 'uses' => 'Admin\CouponController@store_type']);
    Route::resource('coupon', 'Admin\CouponController');

    // Categries
    Route::delete('category/deletetype/{id}/{type}', ['as' => 'admin.category.deletetype', 'uses' => 'CategoriesController@destroy']);
    Route::get('category/create', ['as' => 'admin.category.create', 'uses' => 'CategoriesController@create']);
    Route::get('category/store', ['as' => 'admin.category.store', 'uses' => 'CategoriesController@store']);
    Route::resource('category', 'CategoriesController');
    //Reserves
    Route::resource('reserve', 'ReservesController');
    
    // Client chat
    Route::get('chat/line', array('as' => 'admin.client.chat', 'uses' => 'Admin\ChatLineController@chatAdmin'));
    Route::post('chat/contact/seacrch', array('as' => 'chat.seach.contact', 'uses' => 'Admin\ChatLineController@searchContact'));
    
});

// Enduser chat
Route::get('chat/screen/{app_user_id}', 'Admin\ChatLineController@chatScreen');
Route::post('chat/bot', array('as' => 'line.bot', 'uses' => 'Admin\ChatLineController@index'));
Route::get('chat/line/verifined/token/{mid}', array('as' => 'line.verifined.token', 'uses' => 'Admin\ChatLineController@verifinedToken'));
Route::get('chat/verifined', array('as' => 'chat.authentication', 'uses' => 'Admin\ChatLineController@verifined'));
Route::get('chat/login', array('as' => 'chat.login', 'uses' => 'Admin\ChatLineController@login'));

