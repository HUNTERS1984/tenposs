<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;

class TopController extends Controller
{

    protected $request;
    protected $_topRepository;

//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }
    public function __construct(TopsRepositoryInterface $ur,Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    public function index()
    {
//        return $this->_topRepository->getTopMainImage();
        $data = array("images" => $this->_topRepository->getTopMainImage(),
            'news' => $this->_topRepository->getTopNew(),
            'items' => $this->_topRepository->getTopItem(),
            'photos' => $this->_topRepository->getTopPhoto());
        return ResponseUtil::success($data);
//        return $this->_topRepository->all();
    }

    public function top()
    {
        try {
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $data = array("images" => $this->_topRepository->getTopMainImage(),
                    'news' => $this->_topRepository->getTopNew(),
                    'items' => $this->_topRepository->getTopItem(),
                    'photos' => $this->_topRepository->getTopPhoto());
                return ResponseUtil::success($data);
            } else {
                return ResponseUtil::error_detail(1004, []);
            }

        } catch (Exception $e) {
            return ResponseUtil::error_detail(1005, []);
        } finally {

        }
    }

    public function appinfo()
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
                        'menus' => $menus
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data)
                    );
                } else { //get all store off app
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
                        'menus' => $menus
                    );

                    $data1 = array(
                        'id' => 2,
                        'name' => 'App Store 2',
                        'info' => $info1,
                        'setting' => $setting1,
                        'menus' => $menus1
                    );
                    $response = array(
                        'code' => $statusCode,
                        'message' => $message,
                        'data' => array($data, $data1)
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
