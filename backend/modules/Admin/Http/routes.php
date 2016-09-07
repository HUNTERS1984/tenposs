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
    $this->get('register',['middleware'=>'IsLogin','as'=>'admin.register','uses'=>'Auth\AuthController@showRegistrationForm'] );
    $this->post('register',['middleware'=>'IsLogin','as'=>'admin.postRegister','uses'=>'Auth\AuthController@register']);

    // Password Reset Routes...
    $this->get('password/reset/{token?}',['middleware'=>'auth','as'=>'admin.resetPassword','uses'=>'Auth\PasswordController@showResetForm']);
    $this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('password/reset', 'Auth\PasswordController@reset');

    Route::group(['middleware'=>['auth']],function(){
         Route::get('test-ga',['as'=>'admin.ga','uses'=>'AdminController@getAnalytic']);
        // NEWS
        Route::resource('news','NewsController');
        // MENUS
        Route::post('menus/storeMenu',['as'=>'admin.menus.storeMenu','uses'=>'MenusController@storeMenu']);
        Route::resource('menus','MenusController');
        // PHOTO CATS
        Route::resource('photo-cate','PhotoCatController');
        // PHOTO
        Route::resource('photo','PhotoController');
        // STAFF
        Route::resource('staff','StaffController');
    });
});


