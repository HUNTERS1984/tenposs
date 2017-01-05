<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\AppUser;
use App\Models\Push;
use App\Models\PushRegularCurrent;
use App\Utils\HttpRequestUtil;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;


use Session;
use Log;
use DB;

define('REQUEST_NOTIFICATION_ITEMS', 10);

class NotificationController extends Controller
{

    protected $push;
    protected $request;
    protected $push_regular;

    public function __construct(Push $push, PushRegularCurrent $pushRegularCurrent, Request $request)
    {
        $this->push = $push;
        $this->request = $request;
        $this->push_regular = $pushRegularCurrent;
    }

    public function index()
    {
        //type ~ A: all,T: tmp, R: regular, D: delivered
        $type = $this->request->input('type');
        $search_value = $this->request->input('search_value');
        if (empty($type))
            $type = 'A';
        $list_notification = array();
        $user = Session::get('user');
        if ($user == null) {
            return redirect()->route('logout');
        }
        $apps = App::where('user_id', $user->id)->first();
        $app_user = array();
        if (count($apps) > 0)
            $app_user = AppUser::where('app_id', $apps->id)->with('profile')->get();

        //time_type: 1 send now, 2: regular, 3: temp
        switch ($type) {
            case 'A':
                if (!empty($search_value))
                    $list_notification = Push::where('title', 'LIKE', '%' . $search_value . '%')->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                else
                    $list_notification = Push::orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                break;
            case 'T':
                if (!empty($search_value))
                    $list_notification = Push::where('title', 'LIKE', '%' . $search_value . '%')->where('time_type', 3)->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                else
                    $list_notification = Push::where('time_type', 3)->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                break;
            case 'R':
                if (!empty($search_value))
                    $list_notification = Push::where('title', 'LIKE', '%' . $search_value . '%')->where('time_type', 2)->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                else
                    $list_notification = Push::where('time_type', 2)->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                break;
            case 'D':
                if (!empty($search_value))
                    $list_notification = Push::where('title', 'LIKE', '%' . $search_value . '%')->where('status', 1)->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                else
                    $list_notification = Push::where('status', 1)->orderBy('created_at', 'desc')->paginate(REQUEST_NOTIFICATION_ITEMS);
                break;
            default:
                break;
        }
       
        //dd($app_user);
        return view('admin.pages.push.index', compact('app_user', 'list_notification', 'type', 'search_value'));
    }

    public function store()
    {
        try {
            $user = Session::get('user');
            if ($user == null) {
                return redirect()->route('logout');
            }
            $apps = App::where('user_id', $user->id)->first();
            $id = $this->request->input('id');
            if ($id > 0)
                $this->push = Push::find($id);
            else
                $this->push = new Push();
            $this->push->title = $this->request->input('title');
            $this->push->message = $this->request->input('message');
            $this->push->auth_user_id = $this->request->input('auth_user_id');
            $this->push->segment_all_user = $this->request->input('all_user');
            $this->push->segment_client_users = $this->request->input('client_users');
            $this->push->segment_end_users = $this->request->input('end_users');
            $this->push->segment_a_user = $this->request->input('a_user');
            $this->push->time_type = $this->request->input('time_type');
            $this->push->app_app_id = $apps->app_app_id;
            if ($this->request->input('time_type') == 1) {
                HttpRequestUtil::getInstance()->post_data_with_token(
                    Config::get('api.url_api_notification'),
                    array('notification_to' => $this->request->input('auth_user_id'),
                        'title' => $this->request->input('title'),
                        'message' => $this->request->input('message'),
                        'type' => 'custom',
                        'all_user' => $this->request->input('all_user'),
                        'client_users' => $this->request->input('client_users'),
                        'end_users' => $this->request->input('end_users'),
                        'app_id' => $apps->app_app_id),
                    Session::get('jwt_token')->token
                );
                $this->push->status = 1;
                $this->push->save();
            } else if ($this->request->input('time_type') == 2) //regular
            {
                $time_count_repeat = $this->request->input('time_count_repeat');
                $time_detail_type = $this->request->input('time_detail_type');
                $time_detail_hours = $this->request->input('time_detail_hours');
//                if ($time_detail_hours < 10)
//                    $time_detail_hours = '0' . $time_detail_hours;
                $time_detail_minutes = $this->request->input('time_detail_minutes');
//                if ($time_detail_minutes < 10)
//                    $time_detail_minutes = '0' . $time_detail_minutes;
                $time_string = $time_detail_hours . ':' . $time_detail_minutes . ":00 " . $time_detail_type;
//                $time = Carbon::createFromFormat("Y/m/d h:i:s a",$time_string)->setTimezone('UTC');;
                $time = \DateTime::createFromFormat('h:i:s a', $time_string);
                $this->push->time_count_repeat = $time_count_repeat;
                $this->push->time_count_delivered = 0;
                $this->push->time_regular = $time->format('H:i:s');
                $this->push->time_regular_string = $time_string;
                $this->push->status = 2;
                $this->push->save();

                $this->push_regular = new PushRegularCurrent();
                $this->push_regular->title = $this->request->input('title');
                $this->push_regular->message = $this->request->input('message');
                $this->push_regular->auth_user_id = $this->request->input('auth_user_id');
                $this->push_regular->time_type = $this->request->input('time_type');
                $this->push_regular->time_count_repeat = $time_count_repeat;
                $this->push_regular->time_count_delivered = 0;
                $this->push_regular->time_detail_type = '24 hours';
                if ($this->request->input('time_detail_type') == 'pm')
                    $time_detail_hours += 12;
                $this->push_regular->time_detail_hours = $time_detail_hours;
                $this->push_regular->time_detail_minutes = $time_detail_minutes;
                $this->push_regular->push_id = $this->push->id;
                $this->push_regular->save();
            } else {
                
                $time_detail_year = $this->request->input('time_detail_year');
                $time_detail_month = $this->request->input('time_detail_month');
//                if ($time_detail_month < 10)
//                    $time_detail_month = '0' . $time_detail_month;
                $time_detail_day = $this->request->input('time_detail_day');
//                if ($time_detail_day < 10)
//                    $time_detail_day = '0' . $time_detail_day;
                $time_detail_type = $this->request->input('time_detail_type');
                $time_detail_hours = $this->request->input('time_detail_hours');
//                if ($time_detail_hours < 10)
//                    $time_detail_hours = '0' . $time_detail_hours;
                $time_detail_minutes = $this->request->input('time_detail_minutes');
//                if ($time_detail_minutes < 10)
//                    $time_detail_minutes = '0' . $time_detail_minutes;
                $time_string = $time_detail_year . '/' . $time_detail_month .
                    '/' . $time_detail_day . ' ' . $time_detail_hours . ':' . $time_detail_minutes . ":00 " . $time_detail_type;

                    
                $time = \DateTime::createFromFormat('Y-m-d H:i:s', $time_string);
                $this->push->time_count_repeat = 1;
                $this->push->time_count_delivered = 0;
                $this->push->time_selected = $time; //tmp
                $this->push->time_selected_string = $time_string; //tmp
                
                $this->push->status = 3; //tmp
                $this->push->save();

                $this->push_regular = new PushRegularCurrent();
                $this->push_regular->title = $this->request->input('title');
                $this->push_regular->message = $this->request->input('message');
                $this->push_regular->auth_user_id = $this->request->input('auth_user_id');
                $this->push_regular->time_type = $this->request->input('time_type');
                $this->push_regular->time_count_repeat = 1;
                $this->push_regular->time_count_delivered = 0;
                $this->push_regular->time_detail_year = $time_detail_year;
                $this->push_regular->time_detail_month = $time_detail_month;
                $this->push_regular->time_detail_day = $time_detail_day;
                $this->push_regular->time_detail_type = '24 hours';
                if ($this->request->input('time_detail_type') == 'pm')
                    $time_detail_hours += 12;
                $this->push_regular->time_detail_hours = $time_detail_hours;
                $this->push_regular->time_detail_minutes = $time_detail_minutes;
                $this->push_regular->push_id = $this->push->id;
                $this->push_regular->save();
            }
        } catch (QueryException $e) {
            dd($e);
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return 0;
//            return redirect()->back()->withErrors('Cannot create the category');
        }
        return 1;
    }

    public function edit($id)
    {
        try {
            $data = Push::find($id)->toArray();
            if (count($data) > 0)
                return \Illuminate\Support\Facades\Response::json($data);

        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return null;
    }

}
