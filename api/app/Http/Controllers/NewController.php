<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class NewController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    //
    public function index()
    {
        try
        {
            $app_user_id = $this->request['app_user_id'];
            $token = $this->request['token'];
            $time = $this->request['time'];
            $sig = $this->request['sig'];
            $pageindex = $this->request['pageindex'];
            $pagesize = $this->request['pagesize'];
            if (!empty($token) && !empty($time) && !empty($sig)) { //input ok
                $statusCode = 1000;
                $message = 'OK';

                $news = [
                    array('store_id'=>1,'id' => 1, "title" => 'Title 1', 'image_url'=>'Image1.jpg','description'=> 'description 1','menu_id'=>1,'menu_name'=>'Name 1'),
                    array('store_id'=>1,'id' => 2, "title" => 'Title 2', 'image_url'=>'Image1.jpg','description'=> 'description 2','menu_id'=>1,'menu_name'=>'Name 1'),
                    array('store_id'=>1,'id' => 3, "title" => 'Title 3', 'image_url'=>'Image1.jpg','description'=> 'description 3','menu_id'=>2,'menu_name'=>'Name 2'),
                    array('store_id'=>2,'id' => 4, "title" => 'Title 4', 'image_url'=>'Image1.jpg','description'=> 'description 4','menu_id'=>2,'menu_name'=>'Name 2'),
                    array('store_id'=>2,'id' => 5, "title" => 'Title 5', 'image_url'=>'Image1.jpg','description'=> 'description 5','menu_id'=>3,'menu_name'=>'Name 3'),
                    array('store_id'=>2,'id' => 6, "title" => 'Title 6', 'image_url'=>'Image1.jpg','description'=> 'description 6','menu_id'=>3,'menu_name'=>'Name 4'),
                ];

                $notification = [
                        array('message' => 'message 1'),
                        array('message' => 'message 2'),
                        array('message' => 'message 3'),
                        array('message' => 'message 4'),
                        array('message' => 'message 5'),
                ];

                $data = array(
                    'news' => $news,
                    'notification' =>$notification,
                    'totalnew' => 6
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
        }
        catch (Exception $e)
        {
            $statusCode = 1005;
            $message = 'Unknown error';
            $response = array(
                'code' => $statusCode,
                'message' => $message,
                'data' => []
            );
        }
        finally {
            return response()->json($response);
        }
    }
}
