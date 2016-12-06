<?php

namespace App\Http\Controllers\Admin;

use App\Models\App;
use App\Utils\ConvertUtils;
use App\Utils\HttpRequestUtil;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AppsRepositoryInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Session;
use App\Filters\EntityFilters\AppsFilters;

use JWTAuth;


class AppsController extends Controller
{
    //
    protected $appRepo;
    protected $userRepo;

    public function __construct(AppsRepositoryInterface $appRepoInterface, UsersRepositoryInterface $userRepository)
    {
        $this->appRepo = $appRepoInterface;
        $this->userRepo = $userRepository;
    }

    public function index(AppsFilters $filters, $user_id)
    {

        return view('admin.apps.index',
            [
                'user_id' => $user_id,
                'apps' => $this->appRepo->fetchAppsByUser($filters, $user_id)
            ]);

    }

    public function create($user_id)
    {
        return view('admin.apps.create', ['user_id' => $user_id]);
    }

    public function store(Request $request, $user_id)
    {
        if ($request->isMethod('post')) {
            if ($user_id < 1)
                abort(404);

            if ($request->input('mode') == '_create_new') {
                $rules = [
                    'name' => 'required',
                    'app_app_id' => 'required',
                    'app_app_secret' => 'required',
                    'user_id' => 'required'
                ];
                $v = Validator::make($request->all(), $rules);
                if ($v->fails()) {
                    return back()->withInput()->withErrors($v);
                }
//                $created = $this->appRepo->storeApp($this->userRepo->find($user_id), [
//                    'name' => $request->input('name'),
//                    'app_app_id' => $request->input('app_app_id'),
//                    'app_app_secret' => $request->input('app_app_secret'),
//                    'description' => $request->input('description'),
//                    'status' => $request->input('status')
//                ]);
                try {
                    $apps = new App();
                    $apps->name = $request->input('name');
                    $apps->app_app_id = $request->input('app_app_id');
                    $apps->app_app_secret = $request->input('app_app_secret');
                    $apps->description = $request->input('description');
                    $apps->status = $request->input('status');
                    $apps->user_id = $user_id;
                    $apps->save();
                    Session::flash('message', array('class' => 'alert-success', 'detail' => 'Insert successful!'));
                    return redirect()->route('admin.clients.show', ['user_id' => $user_id]);
                } catch (QueryException $e) {
                    Log::error($e->getMessage());
                    Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Insert fail!'));
                    return back()->withInput();
                }

            }
        }
        abort(403);
    }

    public function edit(Request $request, $user_id, $app_id)
    {
        $user = $this->userRepo->find($user_id);
        $app = $this->appRepo->show($user, $app_id);
        return view('admin.apps.update', ['app' => $app, 'user' => $user]);

    }

    public function update(Request $request, $user_id, $app_id)
    {
        $rules = [
            'name' => 'required',
            'app_app_id' => 'required',
            'app_app_secret' => 'required',
            'user_id' => 'required',
            'app_id' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return back()->withInput()->withErrors($v);
        }
        $user = $this->userRepo->find($user_id);
        $updated = $this->appRepo->updateApp($user, $app_id, [
            'name' => $request->input('name'),
            'app_app_id' => $request->input('app_app_id'),
            'app_app_secret' => $request->input('app_app_secret'),
            'description' => $request->input('description'),
            'status' => $request->input('status')
        ]);
        if ($updated) {
            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Updated successful!'));

        } else {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Updated fail!'));
        }
        return back();

    }

    public function delete($user_id, $app_id)
    {
        $removed = $this->appRepo->remove($user_id, $app_id);
        if ($removed) {
            Session::flash('message', array('class' => 'alert-success', 'detail' => 'Delete successful!'));
        } else {
            Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Delete fail!'));
        }
        return back();
    }

    public function setting(AppsFilters $filters, $user_id, $app_id)
    {

//        $data = $this->appRepo->getAppInfoById($app_id);
//        dd($data);
        $apps = App::find($app_id);
        if (count($apps) > 0) {
            $url = Config::get('api.url_get_notification_configure') . $apps->app_app_id;
            $data = HttpRequestUtil::getInstance()->get_data_with_token($url, \Illuminate\Support\Facades\Session::get('jwt_token')->token);

            $android_status = 0;
            $ios_status = 0;
            $web_status = 0;
            $staff_android_status = 0;
            $staff_ios_status = 0;
            $ga_status = 0;
            $array = 0;
            if ($data != null) {
                if (!empty($data[0]->android_push_api_key) && !empty($data[0]->android_push_service_file))
                    $android_status = 1;
                if (!empty($data[0]->apple_push_cer_password) && !empty($data[0]->apple_push_cer_file))
                    $ios_status = 1;
                if (!empty($data[0]->web_push_server_key) && !empty($data[0]->web_push_sender_id))
                    $web_status = 1;
                if (!empty($data[0]->staff_android_push_api_key) && !empty($data[0]->staff_android_push_service_file))
                    $staff_android_status = 1;
                if (!empty($data[0]->staff_apple_push_cer_file) && !empty($data[0]->staff_apple_push_cer_password))
                    $staff_ios_status = 1;
                if (!empty($data[0]->google_analytics_file))
                    $ga_status = 1;
                $array = json_decode(json_encode($data[0]), True);
            }
            return view('admin.apps.setting',
                [
                    'user_id' => $user_id,
                    'app_id' => $app_id,
//                'apps' => $this->appRepo->fetchAppsByUser($filters,$user_id)
                    'android_status' => $android_status,
                    'staff_android_status' => $staff_android_status,
                    'ios_status' => $ios_status,
                    'staff_ios_status' => $staff_ios_status,
                    'web_status' => $web_status,
                    'ga_status' => $ga_status,
                    'data' => $array
                ]);
        }
        abort(403);

    }

    public function upload(Request $request, $user_id, $app_id)
    {
        if ($request->isMethod('post')) {
            // is create new apps
            $flatform = $request->input('flatform');
            if ($flatform == 'web') {
                $rules = [
                    'senderid' => 'required',
                    'apikey' => 'required'
                ];
            } else {
                $rules = [
                    'file' => 'required',
                    'apikey' => 'required'
                ];
            }
            $v = Validator::make($request->all(), $rules);
            if ($v->fails()) {
                return back()->withInput()->withErrors($v);
            }
            try {
                $apps = App::find($app_id);
            }catch (QueryException $e)
            {
                Log::error($e->getMessage());
            }
            if (count($apps) < 1)
                abort(403);
            $app_app_id = $apps->app_app_id;
//            $imageTempName = $request->file('file')->getPathname();
            if ($request->file('file')) {
                $fileName = $request->file('file')->getClientOriginalName();
                $destinationPath = public_path('uploads'); // upload path
                $request->file('file')->move($destinationPath, $fileName);
//            $extension = pathinfo($imageName, PATHINFO_EXTENSION);
//            $filename = '';
//            if ($extension == 'p12')
//                $filename = ConvertUtils::convert_p12_to_pem($path . $imageName, $request->input('apikey'), $pathAppend);
                $url = 'uploads/' . $fileName;
                if (function_exists('curl_file_create')) { // php 5.6+
                    $cFile = curl_file_create(public_path($url));
                } else { //
                    $cFile = '@' . public_path($url);
                }
            }
            $params = null;
            switch ($flatform) {
                case 'android':
                    $params = [
                        'platform' => $flatform,
                        'app_id' => $app_app_id,
                        'push_key' => $request->input('apikey'),
                        'push_file' => $cFile
                    ];
                    break;
                case 'android_staff':
                    $params = [
                        'platform' => $flatform,
                        'app_id' => $app_app_id,
                        'push_key' => $request->input('apikey'),
                        'push_file' => $cFile
                    ];
                    break;
                case 'ios':
                    $params = [
                        'platform' => $flatform,
                        'app_id' => $app_app_id,
                        'push_key' => $request->input('apikey'),
                        'push_file' => $cFile
                    ];
                    break;
                case 'ios_staff':
                    $params = [
                        'platform' => $flatform,
                        'app_id' => $app_app_id,
                        'push_key' => $request->input('apikey'),
                        'push_file' => $cFile
                    ];
                    break;
                case 'web':
                    $params = [
                        'platform' => $flatform,
                        'app_id' => $app_app_id,
                        'push_key' => $request->input('apikey'),
                        'sender_id' => $request->input('senderid')
                    ];
                    break;
                default:
                    break;
            }
//            print_r($params);
            if ($params != null && count($params) > 0) {
                $updated = HttpRequestUtil::getInstance()->post_data_file(Config::get('api.url_upload_file_notification_configure')
                    , $params, \Illuminate\Support\Facades\Session::get('jwt_token')->token);
//print_r($updated);die;
                if ($updated) {
                    Session::flash('message', array('class' => 'alert-success', 'detail' => 'Configure successful!'));

                } else {
                    Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Configure fail!'));
                }
            } else {
                Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Data configure fail!'));
            }
            return back();
        }
        abort(403);
    }

    public function upload_web(Request $request, $user_id, $app_id)
    {
        if ($request->isMethod('post')) {
            // is create new apps
            $rules = [
                'senderid' => 'required',
                'apikey' => 'required'
            ];
            $v = Validator::make($request->all(), $rules);
            if ($v->fails()) {
                return back()->withInput()->withErrors($v);
            }
            $dataUpdate = [
                'web_push_server_key' => $request->input('apikey'),
                'web_push_sender_id' => $request->input('senderid')
            ];


            if ($dataUpdate != null && count($dataUpdate) > 0) {
                $updated = $this->appRepo->updateNotifyInfo($app_id, $dataUpdate);
                if ($updated) {
                    Session::flash('message', array('class' => 'alert-success', 'detail' => 'Configure successful!'));

                } else {
                    Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Configure fail!'));
                }
            } else {
                Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Data configure fail!'));
            }
            return back();
        }
        abort(403);
    }
}
