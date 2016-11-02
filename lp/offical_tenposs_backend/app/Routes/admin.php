<?php

Route::group(['prefix' => 'admin', 'middleware' => ['jwt.auth.custom'] ], function(){
	Route::get('/',['as' => 'admin.client.dashboard', 'uses' => 'Admin\AdminController@dashboard' ] );	
    Route::get('/top',['as' => 'admin.client.top', 'uses' => 'Admin\AdminController@top' ] );
    Route::get('/global',['as' => 'admin.client.global', 'uses' => 'Admin\AdminController@globalpage' ] );
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



