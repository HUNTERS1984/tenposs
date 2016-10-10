<?php

namespace App\Http\Controllers;

use App\Utils\HttpRequestUtil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    //
    public function get_notification($key)
    {
        $data = HttpRequestUtil::getInstance()->get_data('get_data_web_notification',
            [
                'app_id' => $this->app->app_app_id,
                'key' => $key
            ]
            , $this->app->app_app_secret);
        if (!empty($data)) {
            $data = json_decode($data);
            if ($data->code == '1000') {
                $type = '';
                if (count($data->data->info) > 0)
                    $type = $data->data->info->type;
                $id = 0;
                $title = '';
                $description = '';
                if (count($data->data->detail) > 0) {

                    if (array_key_exists('id', $data->data->detail))
                        $id = $data->data->detail->id;
                    $title = $data->data->detail->title;
                    $description = $data->data->detail->description;
                }
                $url = '';
                switch ($type) {
                    case "news":
                        $url = route('news.detail', $id);
                        break;
                    case "coupon":
                        $url = route('coupon.detail', $id);
                        break;
                    case "chat":
                        $url = route('chat');
                    default:
                        break;
                }
                $rs_data = array('type' => $type, 'id' => $id, 'title' => $title,
                    'description' => $description, 'icon' => '',
                    'url' => $url);
                return Response::json($rs_data);
            }
        }
        $rs_data = array('type' => '', 'id' => 0, 'title' => '', 'description' => '', 'icon' => '', 'url' => '');
        return Response::json($rs_data);
    }
}
