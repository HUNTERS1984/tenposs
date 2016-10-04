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
        
        
        Route::get('/login', ['as'=> 'login', 'uses' => 'LoginController@login']);
        Route::get('/register', ['as'=> 'register', 'uses' => 'LoginController@register']);
        Route::post('/register', ['as'=> 'register.post', 'uses' => 'LoginController@registerPost']);
        Route::get('/login/normal', ['as'=> 'login.normal', 'uses' => 'LoginController@loginNormal']);
        Route::post('/login/normal', ['as'=> 'login.normal.post', 'uses' => 'LoginController@loginNormalPost']);
        Route::get('/logout', ['as'=> 'logout', 'uses' => 'LoginController@logout']);
        
        //Social Login
        Route::get('/login/{provider?}',[
            'uses' => 'LoginController@getSocialAuth',
            'as'   => 'auth.getSocialAuth'
        ]);
        Route::get('/login/callback/{provider?}',[
            'uses' => 'LoginController@getSocialAuthCallback',
            'as'   => 'auth.getSocialAuthCallback'
        ]);
        
        Route::get('/user/profile',[ 'as' => 'profile', 'uses' => 'MobileController@profile']);
        //Menu
        Route::get('/menus',[ 'as' => 'menu', 'uses' => 'MenusController@index']);
        Route::get('/menus_detail','MenusController@detail');
        
        Route::get('/news',[ 'as' => 'news', 'uses' => 'MenusController@index']); 
        Route::get('/reservation',[ 'as' => 'reservation', 'uses' => 'MenusController@index']); 
        Route::get('/photo',[ 'as' => 'photo.gallery', 'uses' => 'MenusController@index']); 
        Route::get('/home',[ 'as' => 'home', 'uses' => 'MenusController@index']); 
        Route::get('/chat',[ 'as' => 'chat', 'uses' => 'MobileController@chat']); 
        Route::get('/staff',[ 'as' => 'staff', 'uses' => 'MenusController@index']); 
        Route::get('/coupon',[ 'as' => 'coupon', 'uses' => 'MenusController@index']); 
        Route::get('/configuration',[ 'as' => 'configuration', 'uses' => 'MenusController@index']); 
        
        
    } );
};


Route::group( ['domain' => '{name}.'.env('APP_DOMAIN') ], $appRoutes);
Route::group( ['domain' => env('APP_DOMAIN') ], $appRoutes);



Route::get('/test', function () {
    $arr = array('app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    $secret_key = "ádsadsadsa"; //lay tu app_app_secret
    return \App\Utils\HttpRequestUtil::getInstance()->get_data('appinfo', $arr,$secret_key);

    $arr_post = array('email' => 'bangnk@a.a',
        'password' => '123456',
        'app_id' => '2a33ba4ea5c9d70f9eb22903ad1fb8b2');
    $secret_key = "ádsadsadsa"; //lay tu app_app_secret
    return \App\Utils\HttpRequestUtil::getInstance()->post_data('signin',$arr_post,$secret_key);
});




