<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Admin\Http\Requests\ImageRequest;

use App\Models\Users;
use Carbon\Carbon;

class StaffController extends Controller
{
	protected $entity;
	protected $request;
    public function __construct(Request $request, Users $users){

    	$this->middleware('isAdmin');

    	$this->entity = $users;
    	$this->request = $request;
    }

    public function index()
    {
    	$all_user = $this->entity->orderBy('id','DESC')->get();
    	return view('admin::pages.staff.index',compact('all_user'));
    }

    public function create()
    {

    }

    public function store(ImageRequest $imgrequest)
    {
    	 if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = env('UPLOAD_PATH');
            $filename = time().'.'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 300){
                \Image::make($file->getRealPath())->resize(300,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }else{
                $file->move($destinationPath,$filename);
            }
            $img_url = $destinationPath.'/'.$filename;
        }else{
            $img_url = env('ASSETS_BACKEND').'/images/no-user-image.gif';
        }
        // dd(date('Y-m-d',strtotime($this->request->input('dob'))));
   		$data = [
   			'name' => $this->request->input('name'),
   			'email' => $this->request->input('email'),
   			'password' => \Hash::make($this->request->input('password')),
   			'fullname' => $this->request->input('fullname'),
   			'sex' => $this->request->input('sex'),
   			'birthday' => Carbon::createFromFormat('Y-m-d',$this->request->input('dob'))->format('Y-m-d'),
   			'company' => $this->request->input('company'),
   			'address' => $this->request->input('address'),
   			'tel' => $this->request->input('tel'),
   			'role' => $this->request->input('role'),
   			'image_user' => $img_url,
   		];
   		$this->entity->create($data);

   		return redirect()->route('admin.staff.index');
    }
    public function show($id)
    {

    }

    public function edit($id)
    {
    	$all_user = $this->entity->orderBy('id','DESC')->get();
    	$user = $this->entity->find($id);
    	$list_role = $this->entity->lists('role','role');
    	$list_sex = $this->entity->lists('sex','sex');
    	return view('admin::pages.staff.edit',compact('all_user','user','list_role','list_sex'));

    }

    public function update(ImageRequest $imgrequest,$id)
    {
    	if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = env('UPLOAD_PATH');
            $filename = time().'.'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 300){
                \Image::make($file->getRealPath())->resize(300,null)->save($destinationPath.'/'.$filename);
            }else{
                $file->move($destinationPath,$filename);
            }
            $img_url = $destinationPath.'/'.$filename;
    	}else{
            $img_url = $this->request->input('img_bk');
    	}
    	$all_user = $this->entity->orderBy('id','DESC')->get();
    	$user = $this->entity->find($id);
    	$user->name = $this->request->input('name');
    	$user->email = $this->request->input('email');
    	$user->password = $this->request->input('password');
    	$user->fullname = $this->request->input('fullname');
    	$user->sex = $this->request->input('sex');
    	$user->birthday = Carbon::createFromFormat('Y-m-d',$this->request->input('birthday'))->format('Y-m-d');
    	$user->company = $this->request->input('company');
    	$user->address = $this->request->input('address');
    	$user->tel = $this->request->input('tel');
    	$user->role = $this->request->input('role');
    	$user->image_user = $img_url;
    	$user->save();

    	return redirect()->route('admin.staff.index');
    }

    public function destroy($id)
    {
    	$this->entity->destroy($id);
    	return redirect()->back();
    }
}
