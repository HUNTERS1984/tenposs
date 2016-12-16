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
        'middleware' => ['verify.app'] ], function(){

        Route::get('/',['as' => 'index', 'uses' => 'MobileController@index'] );
        //User
        Route::get('/login', ['as'=> 'login', 'uses' => 'LoginController@login']);
        Route::get('/register', ['as'=> 'register', 'uses' => 'LoginController@register']);
        Route::post('/register', ['as'=> 'register.post', 'uses' => 'LoginController@registerPost','middleware' => 'auth.custom']);
        Route::get('/register/step2', ['as'=> 'register.step2', 'uses' => 'LoginController@registerStep2']);
        Route::post('/register/step2', ['as'=> 'register.step2.post', 'uses' => 'LoginController@registerStep2Post']);
        Route::get('/login/normal', ['as'=> 'login.normal', 'uses' => 'LoginController@loginNormal']);
        Route::post('/login/normal', ['as'=> 'login.normal.post', 'uses' => 'LoginController@loginNormalPost']);
        Route::get('/logout', ['as'=> 'logout', 'uses' => 'LoginController@logout']);
        Route::get('/user/profile',['middleware' => 'auth.custom','as' => 'profile', 'uses' => 'LoginController@profile']);
        Route::post('/user/profile',['middleware' => 'auth.custom','as' => 'profile.save', 'uses' => 'LoginController@profilePost']);

        // Social Login
        Route::get('/login/facebook',['uses' => 'LoginController@loginWithFacebook','as'   => 'login.facebook']);
        Route::get('/login/twitter',['uses' => 'LoginController@loginWithTwitter','as'   => 'login.twitter']);

        // Social connect
        Route::get('/social/connect',['uses' => 'LoginController@socialConnect','as'   => 'social.connect',
            'middleware' => 'auth.custom'
        ]);
        
        Route::get('/social/cancel/{type}',['uses' => 'LoginController@socialCancelConnect','as'   => 'social.cancel',
            'middleware' => 'auth.custom'
        ]);
        
        Route::get('/connect/instagram',['uses' => 'LoginController@instagramConnect','as'   => 'instagram.connect',
            'middleware' => 'auth.custom'
        ]);
        
        Route::post('/setpushkey',['middleware' => 'auth.custom','as' => 'setpushkey', 'uses' => 'LoginController@setPushKey']);
        
        Route::get('/user-privacy',['as' => 'user.privacy', 'uses' => 'MobileController@userPrivacy']);

        Route::get('/company-info',['as' => 'company.info', 'uses' => 'MobileController@companyInfo']);

        // All pages routing

        Route::get('/menus',[ 'as' => 'menus.index', 'uses' => 'MenusController@index']);
        Route::post('/menus/ajaxLoadmore',[ 'as' => 'menus.ajax', 'uses' => 'MenusController@ajaxLoadmore']);
        Route::get('/menus/detail/{item_id}',[ 'as' => 'menus.detail', 'uses' => 'MenusController@detail']);
        Route::get('/menus/related/{id}',[ 'as' => 'menus.related', 'uses' => 'MenusController@related']);
        Route::get('/menus/related_get_data',[ 'as' => 'menus.related.get_data', 'uses' => 'MenusController@related_get_data']);
        Route::get('/get_notification/{key}',[ 'as' => 'index.get_notification', 'uses' => 'NotificationController@get_notification']);

        Route::get('/news',[ 'as' => 'news', 'uses' => 'NewsController@index']); 
        Route::get('/news/detail/{id}',[ 'as' => 'news.detail', 'uses' => 'NewsController@getDetail']); 
        Route::post('/news/ajaxLoadmore',[ 'as' => 'news.ajax', 'uses' => 'NewsController@ajaxLoadmore']);

        Route::get('/reservation',[ 'as' => 'reservation', 'uses' => 'ReserveController@index']); 
        Route::get('/photo',[ 'as' => 'photo.gallery', 'uses' => 'PhotoController@index']); 
        Route::post('/photo/ajaxLoadmore',[ 'as' => 'photo.ajax', 'uses' => 'PhotoController@ajaxLoadmore']); 

        Route::get('/home',[ 'as' => 'home', 'uses' => 'MobileController@index']);
        Route::get('/chat',[ 'as' => 'chat', 'uses' => 'MobileController@chat','middleware' => 'auth.custom']); 

        Route::get('/staff',[ 'as' => 'staff', 'uses' => 'StaffController@index']);
        Route::get('/staff/detail/{id}',[ 'as' => 'staff.detail', 'uses' => 'StaffController@getDetail']);
        Route::post('/staff/ajaxLoadmore',[ 'as' => 'staff.ajax', 'uses' => 'StaffController@ajaxLoadmore']);
        //Coupon
        Route::get('/coupon',[ 'as' => 'coupon', 'uses' => 'CouponController@index']);
        Route::get('/coupon/get_data',[ 'as' => 'coupon.get_data', 'uses' => 'CouponController@get_data']);
        if( Session::has('user') ){
            Route::get('/coupon/detail/{id}',[ 'middleware' => 'auth.custom', 'as' => 'coupon.detail', 'uses' => 'CouponController@detail']);
        }else{
            Route::get('/coupon/detail/{id}',[ 'as' => 'coupon.detail', 'uses' => 'CouponController@detail']);
        }

        Route::get('/configuration',['middleware' => 'auth.custom','as' => 'configuration', 'uses' => 'MobileController@configuration']);
        Route::post('/configuration/save',[ 'middleware' => 'auth.custom','as' => 'configuration.save', 'uses' => 'MobileController@configurationSave']);

        // You can use "get" or "post" method below for payment..
        Route::get('payment', 'PaypalController@postPayment');
        // This must be get method.
        Route::get('payment/status', 'PaypalController@getPaymentStatus');
    } );
};
Route::group( ['domain' => '{name}.'.env('APP_DOMAIN') ], $appRoutes);
Route::group( ['domain' => env('APP_DOMAIN') ], $appRoutes);


