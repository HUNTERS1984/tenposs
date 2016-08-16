<?php

namespace App\Http\Controllers\Admin;

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

    public function index(AppsFilters $filters,$user_id){

        return view('admin.apps.index',
            [
                'user_id' => $user_id,
                'apps' => $this->appRepo->fetchAppsByUser($filters,$user_id)
            ]);

    }
    public function create($user_id){
        return view('admin.apps.create',['user_id' => $user_id]);
    }

    public function store(Request $request,$user_id){
        if( $request->isMethod('post')){
            // is create new apps

            if ($request->input('mode') == '_create_new'){
                $rules = [
                    'name' => 'required',
                    'user_id' => 'required'
                ];
                $v = Validator::make($request->all(),$rules);
                if ($v->fails())
                {
                    return back()->withInput()->withErrors($v);
                }
                $created = $this->appRepo->storeApp($this->userRepo->find($user_id),[
                    'name' => $request->input('name'),
                    'app_app_id' => $request->input('app_app_id'),
                    'app_app_secret' => $request->input('app_app_secret'),
                    'description' => $request->input('description'),
                    'status' => $request->input('status')
                ]);
                if($created){
                    Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Insert successful!') );
                    return redirect()->route('admin.clients.apps',['user_id' => $user_id]);
                }

                Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Insert fail!') );
                return back()->withInput();

            }
        }
    }
    public function delete($user_id,$app_id){
        $removed = $this->appRepo->remove($user_id,$app_id);
        if($removed){
            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Delete successful!') );
        }else{
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Delete fail!') );
        }
        return back();
    }

}
