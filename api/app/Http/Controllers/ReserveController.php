<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReserveController extends Controller
{
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

                    $photos = [
                        array('id' => 1, 'reserve_url' => 'http://reserve.com',   'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'reserve_url' => 'http://reserve.com',  'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'reserve_url' => 'http://reserve.com',   'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'reserve_url' => 'http://reserve.com', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'reserve_url' => 'http://reserve.com',  'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'reserve_url' => 'http://reserve.com', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];

                    $data = array(
                        'reserve' => $photos,
                        'store_id' => 1,
                        'totalreserve' => 6
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data)
                    );
                } else {
                    $photos = [
                        array('id' => 1, 'reserve_url' => 'http://reserve.com',   'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'reserve_url' => 'http://reserve.com',  'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'reserve_url' => 'http://reserve.com',   'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'reserve_url' => 'http://reserve.com', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'reserve_url' => 'http://reserve.com',  'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'reserve_url' => 'http://reserve.com', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];

                    $data = array(
                        'reserve' => $photos,
                        'store_id' => 1,
                        'totalreserve' => 6
                    );

                    $photos = [
                        array('id' => 7, 'reserve_url' => 'http://reserve.com',   'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 8, 'reserve_url' => 'http://reserve.com',  'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 9, 'reserve_url' => 'http://reserve.com',   'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 10, 'reserve_url' => 'http://reserve.com', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 11, 'reserve_url' => 'http://reserve.com',  'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 12, 'reserve_url' => 'http://reserve.com', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];
                    $data2 = array(
                        'reserve' => $photos,
                        'store_id' => 2,
                        'totalreserve' => 6
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
