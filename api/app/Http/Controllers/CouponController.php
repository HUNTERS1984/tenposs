<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CouponController extends Controller
{
    //
    //
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    //
    public function index()
    {
        try {
            $store_id = $this->request['store_id'];
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            $pageindex = $this->request['pageindex'];
            $pagesize = $this->request['pagesize'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $statusCode = 1000;
                $message = 'OK';
                if (isset($store_id) && $store_id > 0) { //get detail one store

                    $coupons = [
                        array('id' => 1, 'type' => 1, 'title' => 'title 1', 'description' => 'description 1', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'type' => 1, 'title' => 'title 2', 'description' => 'description 2', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'type' => 1, 'title' => 'title 3', 'description' => 'description 3', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'type' => 2, 'title' => 'title 4', 'description' => 'description 4', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'type' => 2, 'title' => 'title 5', 'description' => 'description 5', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'type' => 2, 'title' => 'title 6', 'description' => 'description 6', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];

                    $data = array(
                        'coupon' => $coupons,
                        'store_id' => 1,
                        'totalcoupon' => 6
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data)
                    );
                } else {
                    $coupons = [
                        array('id' => 1, 'type' => 1, 'title' => 'title 1', 'description' => 'description 1', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'type' => 1, 'title' => 'title 2', 'description' => 'description 2', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'type' => 1, 'title' => 'title 3', 'description' => 'description 3', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'type' => 2, 'title' => 'title 4', 'description' => 'description 4', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'type' => 2, 'title' => 'title 5', 'description' => 'description 5', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'type' => 2, 'title' => 'title 6', 'description' => 'description 6', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];

                    $data = array(
                        'coupon' => $coupons,
                        'store_id' => 1,
                        'totalcoupon' => 6
                    );
                    $coupons2 = [
                        array('id' => 1, 'type' => 1, 'title' => 'title 1', 'description' => 'description 1', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'type' => 1, 'title' => 'title 2', 'description' => 'description 2', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'type' => 1, 'title' => 'title 3', 'description' => 'description 3', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'type' => 2, 'title' => 'title 4', 'description' => 'description 4', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'type' => 2, 'title' => 'title 5', 'description' => 'description 5', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'type' => 2, 'title' => 'title 6', 'description' => 'description 6', 'start_date' => '2016-08-04 10:20:40', 'end_date' => '2016-08-04 10:20:40', 'status' => 1, 'image_url' => 'image_url1.jpg', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];
                    $data2 = array(
                        'coupon' => $coupons2,
                        'store_id' => 2,
                        'totalcoupon' => 6
                    );

                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data, $data2)
                    );
                }
            } else {
                $statusCode = 1004;
                $message = 'Param input invalid';
                $response = array(
                    'code' => $statusCode,
                    'message' => $message,
                    'data' => []
                );
            }
        } catch (Exception $e) {
            $statusCode = 1005;
            $message = 'Unknown error';
            $response = array(
                'code' => $statusCode,
                'message' => $message,
                'data' => []
            );
        } finally {
            return response()->json($response);
        }
    }
}
