<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$app->get('/', function () use ($app) {
    return 'test';
});

$app->post('/auth/login', 'Auth\AuthController@postLogin');
$app->get('api/v1/excecuteagreement','PaymentController@excecuteAgreement');

$app->group(['middleware' => 'jwt.auth'], function ($app) {
//    $app->get('/', function () use ($app) {
//        return [
//            'success' => [
//                'app' => $app->version(),
//            ],
//        ];
//    });

    $app->get('/user', function () use ($app) {
        return [
            'success' => [
                'user' => JWTAuth::parseToken()->authenticate(),
            ],
        ];
    });

    $app->get('/auth/refresh', 'App\Http\Controllers\Auth\AuthController@getRefresh');
    $app->delete('/auth/invalidate', 'App\Http\Controllers\Auth\AuthController@deleteInvalidate');
    $app->get('/point','App\Http\Controllers\PointController@get_point_info');
    $app->get('/point/client','App\Http\Controllers\PointController@get_client_point_info');
    $app->post('/point/setting','App\Http\Controllers\PointController@set_point_setting');
    $app->post('/point/bonus/{type}','App\Http\Controllers\PointController@bonus');
    $app->post('/point/payment/method','App\Http\Controllers\PointController@set_payment_method');
    $app->post('/point/request/user','App\Http\Controllers\PointController@request_point_for_end_user');
    $app->post('/point/approve/request/user','App\Http\Controllers\PointController@approve_request_point_for_end_user');
    $app->post('/point/use/user','App\Http\Controllers\PointController@request_use_point_for_end_user');
    $app->post('/point/approve/use/user','App\Http\Controllers\PointController@approve_use_point_for_end_user');
    $app->get('/point/request/list','App\Http\Controllers\PointController@request_list');
    $app->get('/point/use/list','App\Http\Controllers\PointController@use_list');
    $app->get('/point/history','App\Http\Controllers\PointController@history_list');

    $app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers','middleware' => 'jwt.auth'], function($app)
    {
        $app->get('payment','PaymentController@index');
      
        $app->get('payment/{id}','PaymentController@getPayment');
        $app->post('payment','PaymentController@createPayment');

        $app->post('webhook','PaymentController@createWebhook');

        $app->post('billingplan','PaymentController@createBillingPlan');
        $app->get('billingplan','PaymentController@billingPlan');
        $app->get('billingplan/{id}','PaymentController@getBillingPlan');
        $app->get('userplan','PaymentController@getUserBillingPlan');
        $app->put('billingplan/{id}','PaymentController@updateBillingPlan');
        $app->delete('billingplan/{id}','PaymentController@deleteBillingPlan');

        $app->post('billingagreement/{plan_id}','PaymentController@createBillingAgreement');
        $app->delete('billingagreement/{plan_id}','PaymentController@suspendBillingAgreement');
        $app->put('billingagreement/{plan_id}','PaymentController@updateBillingAgreement');

        $app->get('billingtransactions/{agreement_id}','PaymentController@billingTransactions');

    });



});
