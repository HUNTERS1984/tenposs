<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

class TopController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function top()
    {
        try {
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $statusCode = 1000;
                $message = 'OK';
                $items = [
                    array('id' => 1, 'title' => 'item 1', 'price' => '10000', 'image_url' => 'item1.jpg', 'description' => 'description Item1'),
                    array('id' => 2, 'title' => 'item 2', 'price' => '20000', 'image_url' => 'item2.jpg', 'description' => 'description Item2'),
                    array('id' => 3, 'title' => 'item 3', 'price' => '30000', 'image_url' => 'item3.jpg', 'description' => 'description Item3'),
                    array('id' => 4, 'title' => 'item 4', 'price' => '40000', 'image_url' => 'item4.jpg', 'description' => 'description Item4'),
                    array('id' => 5, 'title' => 'item 5', 'price' => '50000', 'image_url' => 'item5.jpg', 'description' => 'description Item5')
                ];
                $photo = [
                    array('id' => 1, 'categoryid' => 1, 'categoryname' => 'Category 1', 'image_url' => 'photo1.png'),
                    array('id' => 2, 'categoryid' => 1, 'categoryname' => 'Category 1', 'image_url' => 'photo2.png'),
                    array('id' => 3, 'categoryid' => 2, 'categoryname' => 'Category 2', 'image_url' => 'photo3.png'),
                    array('id' => 4, 'categoryid' => 2, 'categoryname' => 'Category 2', 'image_url' => 'photo4.png'),
                    array('id' => 5, 'categoryid' => 3, 'categoryname' => 'Category 3', 'image_url' => 'photo5.png'),
                    array('id' => 6, 'categoryid' => 3, 'categoryname' => 'Category 4', 'image_url' => 'photo6.png'),
                ];
                $new = [
                    array('id' => 1, 'title' => 'News 1', 'description' => 'description news 1', 'date' => '2016-08-03', 'image_url' => 'news1.jpg'),
                    array('id' => 2, 'title' => 'News 2', 'description' => 'description news 2', 'date' => '2016-08-02', 'image_url' => 'news2.jpg'),
                    array('id' => 3, 'title' => 'News 3', 'description' => 'description news 3', 'date' => '2016-08-02', 'image_url' => 'news3.jpg'),
                    array('id' => 4, 'title' => 'News 4', 'description' => 'description news 4', 'date' => '2016-08-04', 'image_url' => 'news4.jpg'),
                    array('id' => 5, 'title' => 'News 5', 'description' => 'description news 5', 'date' => '2016-08-04', 'image_url' => 'news5.jpg'),
                ];
                $images = [
                    array('image_url' => 'slideimage1.jpg'),
                    array('image_url' => 'slideimage4.jpg'),
                    array('image_url' => 'slideimage3.jpg'),
                    array('image_url' => 'slideimage2.jpg'),
                ];
                $data = array(
                    'store_id' =>1,
                    'items' => $items,
                    'photos' => $photo,
                    'news' => $new,
                    'images' => $images
                );
                $data2 = array(
                    'store_id' =>2,
                    'items' => $items,
                    'photos' => $photo,
                    'news' => $new,
                    'images' => $images
                );
                $response = array(
                    'code' => $statusCode,
                    'message' => $message,
                    'data' => [$data,$data2]
                );
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

    public function appinfo($store_id = null, $token = null, $time = null, $sig = null)
    {
        try {
            $store_id = $this->request['store_id'];
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $statusCode = 1000;
                $message = 'OK';
                if (isset($store_id) && $store_id > 0) { //get detail one store
                    $info = array('latitude' => '324324324324', 'longitude  ' => '32432432432', 'tel' => '2343432432', 'title' => 'Store 1', 'start_time' => '2016-08-02 10:10:10', 'end_time' => '2016-08-02 23:10:10');
                    $setting = array('title' => "App Store 1", 'title_color' => '#sdasda', 'font_size' => 12
                    , 'font_family' => '', 'header_color' => '#aaaaaa', 'menu_icon_color' => '#ffffff', 'menu_background_color' => '#cccccc'
                    , 'menu_font_color' => '', 'menu_font_size' => 14, 'menu_font_family' => '', 'template_id' => 1, 'top_main_image_url' => '');
                    $menus = [
                        array('id' => 1, "name" => 'Menu 1'),
                        array('id' => 2, "name" => 'Menu 2'),
                        array('id' => 3, "name" => 'Menu 3'),
                        array('id' => 4, "name" => 'Menu 4'),
                        array('id' => 5, "name" => 'Menu 5'),
                        array('id' => 6, "name" => 'Menu 6'),
                        array('id' => 7, "name" => 'Menu 7'),
                    ];
                    $data = array(
                        'id' => 1,
                        'name' => 'App Store 1',
                        'info' => $info,
                        'setting' => $setting,
                        'menus' =>$menus
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data)
                    );
                }
                else { //get all store off app
                    $info = array('lat' => '324324324324', 'long' => '32432432432', 'tel' => '2343432432', 'title' => 'Store 1', 'start_time' => '2016-08-02 10:10:10', 'end_time' => '2016-08-02 23:10:10');
                    $setting = array('title' => "App Store 1", 'title_color' => '#sdasda', 'font_size' => 12
                    , 'font_family' => '', 'header_color' => '#aaaaaa', 'menu_icon_color' => '#ffffff', 'menu_background_color' => '#cccccc'
                    , 'menu_font_color' => '', 'menu_font_size' => 14, 'menu_font_family' => '', 'template_id' => 1, 'top_main_image_url' => '');
                    $menus = [
                        array('id' => 1, "name" => 'Menu 1'),
                        array('id' => 2, "name" => 'Menu 2'),
                        array('id' => 3, "name" => 'Menu 3'),
                        array('id' => 4, "name" => 'Menu 4'),
                        array('id' => 5, "name" => 'Menu 5'),
                        array('id' => 6, "name" => 'Menu 6'),
                        array('id' => 7, "name" => 'Menu 7'),
                    ];
                    $info1 = array('lat' => '2343432432', 'long' => '23423432432', 'tel' => '2343432432', 'title' => 'Store 2', 'start_time' => '2016-08-02 10:10:10', 'end_time' => '2016-08-02 23:10:10');
                    $setting1 = array('title' => "App Store 2", 'title_color' => '#sdasda', 'font_size' => 12
                    , 'font_family' => '', 'header_color' => '#aaaaaa', 'menu_icon_color' => '#ffffff', 'menu_background_color' => '#cccccc'
                    , 'menu_font_color' => '', 'menu_font_size' => 14, 'menu_font_family' => '', 'template_id' => 2, 'top_main_image_url' => '');
                    $menus1 = [
                        array('id' => 1, "name" => 'Menu 1'),
                        array('id' => 2, "name" => 'Menu 2'),
                        array('id' => 3, "name" => 'Menu 3'),
                        array('id' => 4, "name" => 'Menu 4'),
                        array('id' => 5, "name" => 'Menu 5'),
                        array('id' => 6, "name" => 'Menu 6'),
                        array('id' => 7, "name" => 'Menu 7'),
                    ];

                    $data = array(
                        'id' => 1,
                        'name' => 'App Store 1',
                        'info' => $info,
                        'setting' => $setting,
                        'menus' =>$menus
                    );

                    $data1 = array(
                        'id' => 2,
                        'name' => 'App Store 2',
                        'info' => $info1,
                        'setting' => $setting1,
                        'menus' =>$menus1
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data,$data1)
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
