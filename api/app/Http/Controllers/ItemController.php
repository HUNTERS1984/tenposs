<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ItemController extends Controller
{
    //
    public function index()
    {
        try {
            $menu_id = $this->request['menu_id'];
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            $pageindex = $this->request['pageindex'];
            $pagesize = $this->request['pagesize'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $statusCode = 1000;
                $message = 'OK';

                $items = [
                    array('id' => 1, "title" => 'Title 1','price'=>'1000','image_url'=>'Image1.jpg','description'=> 'description 1','menu_id'=>1,'menu_name'=>'Name 1'),
                    array('id' => 2, "title" => 'Title 2','price'=>'2000','image_url'=>'Image1.jpg','description'=> 'description 2','menu_id'=>1,'menu_name'=>'Name 1'),
                    array('id' => 3, "title" => 'Title 3','price'=>'3000','image_url'=>'Image1.jpg','description'=> 'description 3','menu_id'=>2,'menu_name'=>'Name 2'),
                    array('id' => 4, "title" => 'Title 4','price'=>'4000','image_url'=>'Image1.jpg','description'=> 'description 4','menu_id'=>2,'menu_name'=>'Name 2'),
                    array('id' => 5, "title" => 'Title 5','price'=>'5000','image_url'=>'Image1.jpg','description'=> 'description 5','menu_id'=>3,'menu_name'=>'Name 3'),
                    array('id' => 6, "title" => 'Title 6','price'=>'6000','image_url'=>'Image1.jpg','description'=> 'description 6','menu_id'=>3,'menu_name'=>'Name 4'),
                ];

                $data = array(
                    'items' => $items,
                    'totalitem' => 6
                );
                $response = array(
                    'code' => $statusCode,
                    'message' => $message,
                    'data' => $data
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

    public function detail()
    {
        try {
            $item_id = $this->request['item_id'];
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $statusCode = 1000;
                $message = 'OK';

                $items =  array('id' => 1, "title" => 'Title 1','price'=>'1000','image_url'=>'Image1.jpg',
                    'description'=> 'description 1','menu_id'=>1,'menu_name'=>'Name 1');

                $itemsRelated = [
                     array('id' => 2, "title" => 'Title 2','price'=>'2000','image_url'=>'Image1.jpg','description'=> 'description 2','menu_id'=>1,'menu_name'=>'Name 1'),
                     ];

                $data = array(
                    'detail' => $items,
                    'items' => $itemsRelated
                );
                $response = array(
                    'code' => $statusCode,
                    'message' => $message,
                    'data' => $data
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
}
