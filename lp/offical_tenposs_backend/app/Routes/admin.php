<?php

Route::group(['prefix' => 'admin', 'middleware' => ['jwt.auth.custom'] ], function(){
    // TOP
    Route::get('/',['as' => 'admin.client.dashboard', 'uses' => 'Admin\AdminController@dashboard' ] );	
    Route::get('top',['as' => 'admin.client.top', 'uses' => 'Admin\AdminController@top' ] );
    Route::post('top', ['as' => 'admin.client.top.store', 'uses' => 'Admin\AdminController@topstore']);

    //GLOBAL
    Route::get('global',['as' => 'admin.client.global', 'uses' => 'Admin\AdminController@globalpage' ] );
    Route::post('global', ['as' => 'admin.client.global.store', 'uses' => 'Admin\AdminController@globalstore']);
    Route::post('global/save-app-icon', ['as' => 'admin.client.global.save.app.icon', 'uses' => 'Admin\AdminController@globalSaveAppIcon']);
    Route::get('global/get-splash-image', ['as' => 'admin.client.global.get.splash_img', 'uses' => 'Admin\AdminController@getSplashImage']);
    Route::post('global/delete-splash-image', ['as' => 'admin.client.global.delete.splash_img', 'uses' => 'Admin\AdminController@deleteSplashImage']);
    Route::post('global/save-splash-image', ['as' => 'admin.client.global.save.splash_img', 'uses' => 'Admin\AdminController@globalSaveSplashImage']);

    // NEWS
    Route::get('news/cat', ['as' => 'admin.news.cat', 'uses' => 'Admin\NewsController@cat']);
    Route::get('news/editcat/{menu_id}', ['as' => 'admin.news.editcat', 'uses' => 'Admin\NewsController@editCat']);
    Route::put('news/updatecat/{menu_id}', ['as' => 'admin.news.updatecat', 'uses' => 'Admin\NewsController@updateCat']);
    Route::post('news/deletecat', ['as' => 'admin.news.deletecat', 'uses' => 'Admin\NewsController@deleteCat']);
    Route::get('news/nextcat', ['as' => 'admin.news.nextcat', 'uses' => 'Admin\NewsController@nextcat']);
    Route::get('news/nextpreview', ['as' => 'admin.news.nextpreview', 'uses' => 'Admin\NewsController@nextpreview']);
    Route::post('news/storeCat', ['as' => 'admin.news.storeCat', 'uses' => 'Admin\NewsController@storeCat']);
    Route::post('news/delete', ['as' => 'admin.news.delete', 'uses' => 'Admin\NewsController@delete']);
    Route::resource('news', 'Admin\NewsController');
    
    // MENUS
    Route::get('menus/cat', ['as' => 'admin.menus.cat', 'uses' => 'Admin\MenusController@cat']);
    Route::get('menus/editcat/{menu_id}', ['as' => 'admin.menus.editcat', 'uses' => 'Admin\MenusController@editCat']);
    Route::put('menus/updatecat/{menu_id}', ['as' => 'admin.menus.updatecat', 'uses' => 'Admin\MenusController@updateCat']);
    Route::post('menus/deletecat', ['as' => 'admin.menus.deletecat', 'uses' => 'Admin\MenusController@deleteCat']);
    Route::get('menus/nextcat', ['as' => 'admin.menus.nextcat', 'uses' => 'Admin\MenusController@nextcat']);
    Route::get('menus/nextpreview', ['as' => 'admin.menus.nextpreview', 'uses' => 'Admin\MenusController@nextpreview']);
    Route::post('menus/storeitem', ['as' => 'admin.menus.storeitem', 'uses' => 'Admin\MenusController@storeitem']);
    Route::post('menus/storeMenu', ['as' => 'admin.menus.storeMenu', 'uses' => 'Admin\MenusController@storeMenu']);
    Route::post('menus/delete', ['as' => 'admin.menus.delete', 'uses' => 'Admin\MenusController@delete']);
    Route::resource('menus', 'Admin\MenusController');
    // PHOTO CATS
    Route::get('photo-cate/cat', ['as' => 'admin.photo-cate.cat', 'uses' => 'Admin\PhotoCatController@cat']);
    Route::get('photo-cate/editcat/{menu_id}', ['as' => 'admin.photo-cate.editcat', 'uses' => 'Admin\PhotoCatController@editCat']);
    Route::put('photo-cate/updatecat/{menu_id}', ['as' => 'admin.photo-cate.updatecat', 'uses' => 'Admin\PhotoCatController@updateCat']);
    Route::post('photo-cate/deletecat', ['as' => 'admin.photo-cate.deletecat', 'uses' => 'Admin\PhotoCatController@deleteCat']);
    Route::get('photo-cate/view_more', ['as' => 'admin.photo-cate.view_more', 'uses' => 'Admin\PhotoCatController@view_more']);
    Route::post('photo-cate/storephoto', ['as' => 'admin.photo-cate.storephoto', 'uses' => 'Admin\PhotoCatController@storephoto']);
    Route::get('photo-cate/nextcat', ['as' => 'admin.photo-cate.nextcat', 'uses' => 'Admin\PhotoCatController@nextcat']);
    Route::get('photo-cate/nextpreview', ['as' => 'admin.photo-cate.nextpreview', 'uses' => 'Admin\PhotoCatController@nextpreview']);
    Route::post('photo-cate/delete', ['as' => 'admin.photo-cate.delete', 'uses' => 'Admin\PhotoCatController@delete']);
    Route::resource('photo-cate', 'Admin\PhotoCatController');
    // STAFF
    Route::get('staff/cat', ['as' => 'admin.staff.cat', 'uses' => 'Admin\StaffController@cat']);
    Route::get('staff/editcat/{menu_id}', ['as' => 'admin.staff.editcat', 'uses' => 'Admin\StaffController@editCat']);
    Route::put('staff/updatecat/{menu_id}', ['as' => 'admin.staff.updatecat', 'uses' => 'Admin\StaffController@updateCat']);
    Route::post('staff/deletecat', ['as' => 'admin.staff.deletecat', 'uses' => 'Admin\StaffController@deleteCat']);
    Route::get('staff/view_more', ['as' => 'admin.staff.view_more', 'uses' => 'Admin\StaffController@view_more']);
    Route::get('staff/nextcat', ['as' => 'admin.staff.nextcat', 'uses' => 'Admin\StaffController@nextcat']);
    Route::get('staff/nextpreview', ['as' => 'admin.staff.nextpreview', 'uses' => 'Admin\StaffController@nextpreview']);
    Route::post('staff/storestaff', ['as' => 'admin.staff.storestaff', 'uses' => 'Admin\StaffController@storestaff']);
    Route::post('staff/storeCat', ['as' => 'admin.staff.storeCat', 'uses' => 'Admin\StaffController@storeCat']);
    Route::post('staff/delete', ['as' => 'admin.staff.delete', 'uses' => 'Admin\StaffController@delete']);
    Route::resource('staff', 'Admin\StaffController');
    // COUPON
    Route::get('coupon/cat', ['as' => 'admin.coupon.cat', 'uses' => 'Admin\CouponController@cat']);
    Route::get('coupon/editcat/{menu_id}', ['as' => 'admin.coupon.editcat', 'uses' => 'Admin\CouponController@editCat']);
    Route::put('coupon/updatecat/{menu_id}', ['as' => 'admin.coupon.updatecat', 'uses' => 'Admin\CouponController@updateCat']);
    Route::post('coupon/deletecat', ['as' => 'admin.coupon.deletecat', 'uses' => 'Admin\CouponController@deleteCat']);
    Route::get('coupon/view_more', ['as' => 'admin.coupon.view_more', 'uses' => 'Admin\CouponController@view_more']);
    Route::get('coupon/approve_all', ['as' => 'admin.coupon.approve_all', 'uses' => 'Admin\CouponController@approve_all']);
    Route::post('coupon/approve', ['as' => 'admin.coupon.approve', 'uses' => 'Admin\CouponController@approve']);
    Route::get('coupon/approve_post/{post_id}', ['as' => 'admin.coupon.approve.post', 'uses' => 'Admin\CouponController@approve_post']);
    Route::get('coupon/unapprove/{post_id}', ['as' => 'admin.coupon.unapprove.post', 'uses' => 'Admin\CouponController@unapprove_post']);
    Route::post('coupon/store_type', ['as' => 'admin.coupon.store_type', 'uses' => 'Admin\CouponController@store_type']);
    Route::post('coupon/delete', ['as' => 'admin.coupon.delete', 'uses' => 'Admin\CouponController@delete']);
    Route::get('coupon/accept', ['as' => 'admin.coupon.accept', 'uses' => 'Admin\CouponController@accept']);
    Route::resource('coupon', 'Admin\CouponController');

    // Categries
    Route::delete('category/deletetype/{id}/{type}', ['as' => 'admin.category.deletetype', 'uses' => 'CategoriesController@destroy']);
    Route::get('category/create', ['as' => 'admin.category.create', 'uses' => 'CategoriesController@create']);
    Route::get('category/store', ['as' => 'admin.category.store', 'uses' => 'CategoriesController@store']);
    Route::resource('category', 'CategoriesController');
    //Reserves
    Route::resource('reserve', 'ReservesController');
    
    // Client chat
    Route::get('chat/line', array('as' => 'admin.client.chat', 'uses' => 'Admin\ClientChatLineController@chatAdmin'));
    Route::post('chat/contact/search', array('as' => 'chat.search.contact', 'uses' => 'Admin\ClientChatLineController@searchContact'));
    
    //Account setting
    Route::get('account',['as' => 'admin.client.account', 'uses' => 'Admin\AdminController@account' ] );
    Route::post('account',['as' => 'admin.client.account.save', 'uses' => 'Admin\AdminController@accountSave' ] );

    //Users managements
    Route::get('users/management',['as' => 'admin.users.management', 'uses' => 'Admin\AdminController@userManagement' ] );
    Route::post('users/management',['as' => 'admin.users.management.post', 'uses' => 'Admin\AdminController@userManagementPost' ] );
    Route::get('users/management/{app_user_id}/detail',['as' => 'admin.users.management.detail', 'uses' => 'Admin\AdminController@userManagementDetail' ] );

    //Help
    Route::get('help',['as' => 'admin.client.help', 'uses' => 'Admin\AdminController@help' ] );

    //Contact
    Route::get('contact',['as' => 'admin.client.contact', 'uses' => 'Admin\AdminController@contact' ] );
    Route::post('contact',['as' => 'admin.client.contact.save', 'uses' => 'Admin\AdminController@saveContact' ] );

    //Cost
    Route::get('cost/register',['as' => 'admin.cost.register', 'uses' => 'Admin\CostController@register' ] );
    Route::get('cost/payment/{type}',['as' => 'admin.cost.payment', 'uses' => 'Admin\CostController@payment' ] );
    Route::post('cost/setting',['as' => 'admin.cost.setting', 'uses' => 'Admin\CostController@setting' ] );
    Route::post('cost/payment_method',['as' => 'admin.cost.payment_method', 'uses' => 'Admin\CostController@payment_method' ] );
    Route::resource('cost', 'Admin\CostController');
    
    //push
    Route::get('push',['as' => 'admin.push.index', 'uses' => 'Admin\NotificationController@index' ] );
    Route::post('push',['as' => 'admin.push.index', 'uses' => 'Admin\NotificationController@index' ] );
    Route::post('push/store',['as' => 'admin.push.store', 'uses' => 'Admin\NotificationController@store' ] );
    Route::get('push/edit/{id}',['as' => 'admin.push.edit', 'uses' => 'Admin\NotificationController@edit' ] );
//    Route::resource('push', 'Admin\NotificationController');
    //analytics
    Route::get('analytic',['as' => 'admin.analytic.google', 'uses' => 'Admin\AnalyticController@google_analytic' ] );
    Route::get('analytic_coupon',['as' => 'admin.analytic.coupon', 'uses' => 'Admin\AnalyticController@coupon_analytic' ] );
    Route::get('analytic_store',['as' => 'admin.analytic.store', 'uses' => 'Admin\AnalyticController@store_analytic' ] );
    Route::get('get_data',['as' => 'admin.analytic.data', 'uses' => 'Admin\AnalyticController@get_data' ] );

});


// Chat for Enduser

Route::group(array('prefix' => 'chat'), function () {
    // Enduser request chat
    Route::get('screen/{auth_user_id}', 'ChatLineController@chatApp');
    //Route::get('app/{app_id}', 'ChatLineController@chatApp');
    // BOT
    Route::any('bot/{chanel_id}', array('as' => 'line.bot', 'uses' => 'ChatLineController@index'));
    /*
    Route::get('screen/{app_user_id}', 'ChatLineController@chatScreen');
    Route::get('request', array('as' => 'chat.request', 'uses' => 'ChatLineController@requestFriend'));
    Route::get('line/{app_user_id}/{mid}', array('as' => 'chat.line', 'uses' => 'ChatLineController@chat'));
    Route::get('line/verifined/token/{mid}', array('as' => 'line.verifined.token', 'uses' => 'ChatLineController@verifinedToken'));
    Route::get('verifined', array('as' => 'chat.authentication', 'uses' => 'ChatLineController@verifined'));
    Route::get('login', array('as' => 'chat.login', 'uses' => 'ChatLineController@login'));
    */
});
