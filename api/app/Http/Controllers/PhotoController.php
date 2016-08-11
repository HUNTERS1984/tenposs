<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PhotoController extends Controller
{
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
            $category_id = $this->request['category_id'];
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
                        array('id' => 1, 'image_url' => 'Image1.jpg', 'category_id' => 1, 'category_name' => 'Name 1', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'image_url' => 'Image2.jpg', 'category_id' => 1, 'category_name' => 'Name 1', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'image_url' => 'Image3.jpg', 'category_id' => 2, 'category_name' => 'Name 2', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'image_url' => 'Image4.jpg', 'category_id' => 2, 'category_name' => 'Name 2', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'image_url' => 'Image5.jpg', 'category_id' => 3, 'category_name' => 'Name 3', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'image_url' => 'Image6.jpg', 'category_id' => 3, 'category_name' => 'Name 4', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];

                    $data = array(
                        'photos' => $photos,
                        'store_id' => 1,
                        'totalphoto' => 6
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data)
                    );
                } else {
                    $photos = [
                        array('id' => 1, 'image_url' => 'Image1.jpg', 'category_id' => 1, 'category_name' => 'Name 1', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 2, 'image_url' => 'Image2.jpg', 'category_id' => 1, 'category_name' => 'Name 1', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 3, 'image_url' => 'Image3.jpg', 'category_id' => 2, 'category_name' => 'Name 2', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 4, 'image_url' => 'Image4.jpg', 'category_id' => 2, 'category_name' => 'Name 2', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 5, 'image_url' => 'Image5.jpg', 'category_id' => 3, 'category_name' => 'Name 3', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 6, 'image_url' => 'Image6.jpg', 'category_id' => 3, 'category_name' => 'Name 4', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];

                    $data = array(
                        'photos' => $photos,
                        'store_id' => 1,
                        'totalphoto' => 6
                    );

                    $photos2 = [
                        array('id' => 7, 'image_url' => 'Image1.jpg', 'category_id' => 4, 'category_name' => 'Name 4', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 8, 'image_url' => 'Image2.jpg', 'category_id' => 4, 'category_name' => 'Name 4', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 9, 'image_url' => 'Image3.jpg', 'category_id' => 5, 'category_name' => 'Name 5', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 10, 'image_url' => 'Image4.jpg', 'category_id' => 5, 'category_name' => 'Name 5', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 11, 'image_url' => 'Image5.jpg', 'category_id' => 6, 'category_name' => 'Name 6', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                        array('id' => 12, 'image_url' => 'Image6.jpg', 'category_id' => 6, 'category_name' => 'Name 6', 'created_at' => '2016-08-04 10:20:40', 'updated_at' => '2016-08-04 10:20:40'),
                    ];
                    $data2 = array(
                        'photos' => $photos,
                        'store_id' => 2,
                        'totalphoto' => 6
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
