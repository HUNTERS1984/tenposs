<?php

namespace App\Http\Controllers\Admin;

use App\Utils\ConvertUtils;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AppsRepositoryInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Validator;
use Session;
use App\Filters\EntityFilters\AppsFilters;


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
            // is create new apps

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
                $created = $this->appRepo->storeApp($this->userRepo->find($user_id), [
                    'name' => $request->input('name'),
                    'app_app_id' => $request->input('app_app_id'),
                    'app_app_secret' => $request->input('app_app_secret'),
                    'description' => $request->input('description'),
                    'status' => $request->input('status')
                ]);
                if ($created) {
                    Session::flash('message', array('class' => 'alert-success', 'detail' => 'Insert successful!'));
                    return redirect()->route('admin.clients.show', ['user_id' => $user_id]);
                }

                Session::flash('message', array('class' => 'alert-danger', 'detail' => 'Insert fail!'));
                return back()->withInput();

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

        $data = $this->appRepo->getAppInfoById($app_id);
//        dd($data);
        $android_status = 0;
        if (!empty($data[0]['android_push_api_key']) && !empty($data[0]['android_push_service_file']))
            $android_status = 1;
        $ios_status = 0;
        if (!empty($data[0]['apple_push_cer_password']) && !empty($data[0]['apple_push_cer_file']))
            $ios_status = 1;
        $web_status = 0;
        if (!empty($data[0]['web_push_server_key']) && !empty($data[0]['web_push_sender_id']))
            $web_status = 1;
        return view('admin.apps.setting',
            [
                'user_id' => $user_id,
                'app_id' => $app_id,
//                'apps' => $this->appRepo->fetchAppsByUser($filters,$user_id)
                'android_status' => $android_status,
                'ios_status' => $ios_status,
                'web_status' => $web_status,
                'data' => $data[0]
            ]);

    }

    public function upload(Request $request, $user_id, $app_id)
    {
        if ($request->isMethod('post')) {
            // is create new apps
            $rules = [
                'file' => 'required',
                'apikey' => 'required'
            ];
            $v = Validator::make($request->all(), $rules);
            if ($v->fails()) {
                return back()->withInput()->withErrors($v);
            }
//            $imageTempName = $request->file('file')->getPathname();
            $imageName = $request->file('file')->getClientOriginalName();
            $pathAppend = '/public/uploads/appsetting/file/';
            $path = base_path() . $pathAppend;
            $request->file('file')->move($path, $imageName);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);
            $filename = '';
            if ($extension == 'p12')
                $filename = ConvertUtils::convert_p12_to_pem($path . $imageName, $request->input('apikey'), $pathAppend);
            $flatform = $request->input('flatform');
            $dataUpdate = null;
            switch ($flatform) {
                case 'android':
                    $dataUpdate = [
                        'android_push_api_key' => $request->input('apikey'),
                        'android_push_service_file' => $pathAppend . $imageName
                    ];
                    break;
                case 'ios':
                    $dataUpdate = [
                        'apple_push_cer_password' => $request->input('apikey'),
                        'apple_push_cer_file' => $pathAppend . $filename
                    ];
                    break;
                default:
                    break;
            }

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
