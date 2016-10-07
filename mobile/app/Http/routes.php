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

$appRoutes = function(){
    Route::group( [ 
        'middleware' => ['verify.app'] , 
        'middlewareGroups' => ['web'] ], function(){
            
        Route::get('/','MobileController@index' );
        
        //User routing
        Route::get('/login', ['as'=> 'login', 'uses' => 'LoginController@login']);
        Route::get('/register', ['as'=> 'register', 'uses' => 'LoginController@register']);
        Route::post('/register', ['as'=> 'register.post', 'uses' => 'LoginController@registerPost']);
        Route::get('/login/normal', ['as'=> 'login.normal', 'uses' => 'LoginController@loginNormal']);
        Route::post('/login/normal', ['as'=> 'login.normal.post', 'uses' => 'LoginController@loginNormalPost']);
        Route::get('/logout', ['as'=> 'logout', 'uses' => 'LoginController@logout']);
        Route::get('/user/profile',[ 
            'middleware' => 'auth.custom',
            'as' => 'profile', 
            'uses' => 'MobileController@profile']);
        
         Route::post('/user/profile',[ 
            'middleware' => 'auth.custom',
            'as' => 'profile', 
            'uses' => 'MobileController@profilePost']);
            
        //Social Login
        Route::get('/login/{provider?}',[
            'uses' => 'LoginController@getSocialAuth',
            'as'   => 'auth.getSocialAuth'
        ]);
        Route::get('/login/callback/{provider?}',[
            'uses' => 'LoginController@getSocialAuthCallback',
            'as'   => 'auth.getSocialAuthCallback'
        ]);
        

        // All pages routing
        /**
         * Mọi người sửa cái controller trỏ tới controller của mình nhé.
         * Phần này Nhiên hardcode để làm sidemenu
         */
        Route::get('/menus',[ 'as' => 'menus.index', 'uses' => 'MenusController@index']);
        Route::get('/menus/get_data',[ 'as' => 'menus.index.get_data', 'uses' => 'MenusController@get_data']);
        Route::get('/menus/detail/{item_id}',[ 'as' => 'menus.detail', 'uses' => 'MenusController@detail']);
        Route::get('/menus/related/{id}',[ 'as' => 'menus.related', 'uses' => 'MenusController@related']);
        Route::get('/menus/related_get_data',[ 'as' => 'menus.related.get_data', 'uses' => 'MenusController@related_get_data']);

        Route::get('/news',[ 'as' => 'news', 'uses' => 'MenusController@index']); 
        Route::get('/reservation',[ 'as' => 'reservation', 'uses' => 'MenusController@index']); 
        Route::get('/photo',[ 'as' => 'photo.gallery', 'uses' => 'MenusController@index']); 
        Route::get('/home',[ 'as' => 'home', 'uses' => 'MenusController@index']); 
        Route::get('/chat',[ 'as' => 'chat', 'uses' => 'MobileController@chat']); 
        Route::get('/staff',[ 'as' => 'staff', 'uses' => 'MenusController@index']);
        //Coupon
        Route::get('/coupon',[ 'as' => 'coupon', 'uses' => 'CouponController@index']);
        Route::get('/coupon/get_data',[ 'as' => 'coupon.get_data', 'uses' => 'CouponController@get_data']);
        Route::get('/coupon/detail/{id}',[ 'as' => 'coupon.detail', 'uses' => 'CouponController@detail']);
        Route::get('/configuration',[
            'middleware' => 'auth.custom',
            'as' => 'configuration', 
            'uses' => 'MobileController@configuration']); 
            
        Route::post('/configuration/save',[ 
            'middleware' => 'auth.custom',
            'as' => 'configuration.save', 
            'uses' => 'MobileController@configurationSave']); 
        
        //End
    } );
};
Route::group( ['domain' => '{name}.'.env('APP_DOMAIN') ], $appRoutes);
Route::group( ['domain' => env('APP_DOMAIN') ], $appRoutes);


