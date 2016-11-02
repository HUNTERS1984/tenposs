<?php

Route::group(['prefix' => 'admin-client', 'middleware' => ['jwt.auth.custom'] ], function(){
	Route::get('/',['as' => 'admin.client.dashboard', 'uses' => 'Admin\AdminController@dashboard' ] );	
    Route::get('/top',['as' => 'admin.client.top', 'uses' => 'Admin\AdminController@top' ] );
    Route::get('/global',['as' => 'admin.client.global', 'uses' => 'Admin\AdminController@globalpage' ] );
});



