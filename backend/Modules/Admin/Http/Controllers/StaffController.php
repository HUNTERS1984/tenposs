<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffCat;
use App\Models\Store;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\ImageRequest;

use App\Models\Users;
use Carbon\Carbon;

define('REQUEST_STAFF_ITEMS',  10);
class StaffController extends Controller
{
	protected $entity;
	protected $request;
	protected $staffcat;
	protected $staff;
	protected $store;

    public function __construct(Request $request, StaffCat $staffcat,Staff $staff,Store $store){

//    	$this->middleware('isAdmin');

    	$this->request = $request;
		$this->staffcat = $staffcat;
		$this->staff = $staff;
		$this->store = $store;
    }

    public function index()
    {
		$stores = $this->request->stores;
		$list_staff = array();
		$list_store = array();
		if (count($stores) > 0) {
			$staff_cat = $this->staffcat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;

			$list_store = $stores->lists('name', 'id');
			//dd($menus->pluck('id')->toArray());
			$list_staff = [];
			if (count($staff_cat) > 0) {
				$list_staff_cat = $staff_cat->pluck('id')->toArray();

				if (count($list_staff_cat) > 0) {

					$list_staff = Staff::whereIn('staff_category_id',$list_staff_cat)->orderBy('updated_at', 'desc')->take(REQUEST_STAFF_ITEMS)->get();

					for ($i = 0; $i < count($list_staff); $i++) {
						if ($list_staff[$i]->image_url == null)
							$list_staff[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
					}
				}

			}
		}
		//dd($list_store);
		return view('admin::pages.staff.index',compact('staff_cat','list_staff', 'list_store'));
    }

    public function create()
    {
		$staff_cat = $this->staffcat->select('name','id')->get();
		$staff_thumbs = $this->staff->select('image_url')->orderBy('id','DESC')->take(8)->get();
		return view('admin::pages.staff.create',compact('staff_cat','staff_thumbs'));

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
   			'price' => $this->request->input('price'),
   			'introduction' => $this->request->input('introduction'),
   			'gender' => $this->request->input('gender'),
   			'tel' => $this->request->input('tel'),
   			'birthday' => Carbon::createFromFormat('Y-m-d',$this->request->input('birthday'))->format('Y-m-d'),
   			'staff_category_id' => $this->request->input('staff_category_id'),
   			'image_url' => $img_url,
   		];
   		$this->staff->create($data);

   		return redirect()->route('admin.staff.index');
    }
    public function show($id)
    {

    }

    public function edit($id)
    {
		$staff_cat = $this->staffcat->orderBy('id', 'DESC')->get();;

		$item = $this->staff->find($id);
//		dd($item);
		return view('admin::pages.staff.edit',compact('item','staff_cat'));

    }

    public function update(ImageRequest $imgrequest,$id)
    {

		$rules = [
			'name' => 'required|Max:255',
			'introduction' => 'required|Min:6',
			'price' => 'required|numeric',
			'tel' =>'required|numeric'
		];
		$v = Validator::make($this->request->all(),$rules);
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v);
		}

		$image_edit = null;
		if($imgrequest->hasFile('image_edit')){
			$file = array('image_edit' => $this->request->image_edit);
			$destinationPath = 'uploads'; // upload path
			$extension = $this->request->image_edit->getClientOriginalExtension(); // getting image extension
			$fileName = md5($this->request->image_edit->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
			$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
			$contentType = mime_content_type($this->request->image_edit->getRealPath());

			if(! in_array($contentType, $allowedMimeTypes) ){
				Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'The uploaded file is not an image') );
				return back()->withInput();
			}
			$this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
			$image_edit = $destinationPath . '/' . $fileName;
		}

		try {
			$item = Staff::find($id);
			$item->name = $this->request->input('name');
			$item->introduction = $this->request->input('introduction');
			$item->price = $this->request->input('price');
			$item->gender = $this->request->input('gender');
			$item->tel = $this->request->input('tel');
			$item->tel = $this->request->input('tel');
			$item->staff_category_id = $this->request->input('staff_category_id');
			if ($image_edit)
				$item->image_url = $image_edit;

			$item->save();
			//delete cache redis
//			RedisControl::delete_cache_redis('menus');
//			RedisControl::delete_cache_redis('items');
//			RedisControl::delete_cache_redis('top_items');
			Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Update staff successfully') );
			return redirect()->route('admin.staff.index');
		} catch (\Illuminate\Database\QueryException $e) {
			Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Update staff fail') );
			return back();
		}
    }

    public function destroy($id)
    {
    	$this->staff->destroy($id);
    	return redirect()->back();
    }

	public function view_more()
	{
		$page_num = $this->request->page;
		$cat = $this->request->cat;

		$stores = $this->request->stores;
		$staff_cat = $this->staffcat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;

		$list_store = $stores->lists('name','id');
		$list_staff = [];
		if (count($staff_cat) > 0) {
			$list_staff_cat = $staff_cat->pluck('id')->toArray();
			if (count ($list_staff_cat) > 0) {
				$staff_category_id = $list_staff_cat[$cat];
				$list_item = Staff::where('staff_category_id',$staff_category_id)->orderBy('updated_at','desc')->take(REQUEST_STAFF_ITEMS)->skip($page_num*REQUEST_STAFF_ITEMS)->get();
				//dd($list_item->toArray());
				for($i = 0; $i < count($list_item); $i++)
				{
					if ($list_staff[$i]->image_url == null)
						$list_staff[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
				}
			}

		}


		$returnHTML = view('admin::pages.staff.element_item')->with(compact('list_staff'))->render();
		return $returnHTML;
	}

	public function nextcat()
	{

		$page_num = $this->request->page;
		$cat = $this->request->cat;

		$stores = $this->request->stores;
		$staff_cat = $this->staffcat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
		$list_store = $stores->lists('name','id');

		$list_staff = [];
		if (count($staff_cat) > 0) {
			$list_staff_cat = $staff_cat->pluck('id')->toArray();
			if (count ($list_staff_cat) > 0) {
				$staff_category_id = $list_staff_cat[$cat];

				$list_staff = Staff::where('staff_category_id',$staff_category_id)->orderBy('updated_at','desc')->take(REQUEST_STAFF_ITEMS)->skip($page_num*REQUEST_STAFF_ITEMS)->get();

				for($i = 0; $i < count($list_staff); $i++)
				{
					if ($list_staff[$i]->image_url == null)
						$list_staff[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
				}
			}

		}

		$returnHTML = view('admin::pages.staff.element_item')->with(compact('list_staff'))->render();
		return $returnHTML;
	}

	public function demo()
	{
		print_r('demo');
	}

	public function nextpreview()
	{
		$page_num = $this->request->page;
		$cat = $this->request->cat;

		$stores = $this->request->stores;
		$staff_cat = $this->staffcat->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
		$list_store = $stores->lists('name','id');
		//dd($menus->pluck('id')->toArray());
		$list_staff = [];
		if (count($staff_cat) > 0) {
			$list_staff_cat = $staff_cat->pluck('id')->toArray();
			if (count ($list_staff_cat) > 0) {
				$staff_category_id = $list_staff_cat[$cat];
				$list_staff = Staff::where('staff_category_id',$staff_category_id)->orderBy('updated_at','desc')->take(REQUEST_STAFF_ITEMS)->skip($page_num*REQUEST_STAFF_ITEMS)->get();
				//dd($list_item->toArray());
				for($i = 0; $i < count($list_staff); $i++)
				{
					if ($list_staff[$i]->image_url == null)
						$list_staff[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
				}
			}

		}

		$returnHTML = view('admin::pages.staff.element_item_preview')->with(compact('list_staff'))->render();
		return $returnHTML;
	}

	public function storeCat(){
		$all = $this->request->all();
//		dd($all);
		$this->staffcat->create($all);
		return redirect()->back();
		$rules = [
			'name' => 'required|Max:255',
		];
		$v = Validator::make($this->request->all(),$rules);
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v);
		}
		try {
			$data = [
				'name' => $this->request->input('name'),
				'store_id' => $this->request->input('store_id'),
			];
			$this->staffcat->create($data);
			//delete cache redis
//			RedisControl::delete_cache_redis('menus');
			Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Add Staff Category successfully') );
			return redirect()->route('admin.staff.index');
		} catch (\Illuminate\Database\QueryException $e) {
			Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Add Staff Category fail') );
			return back();
		}
	}

	public function storestaff()
	{
		$rules = [
			'name' => 'required|Max:255',
			'introduction' => 'required|Min:6',
			'price' => 'required|numeric',
			'tel' =>'required|numeric'
		];
		$v = Validator::make($this->request->all(),$rules);
		if ($v->fails())
		{
			return redirect()->back()->withInput()->withErrors($v);
		}

		if ($this->request->image_create != null && $this->request->image_create->isValid()) {
			$file = array('image_create' => $this->request->image_create);
			$destinationPath = 'uploads'; // upload path
			$extension = $this->request->image_create->getClientOriginalExtension(); // getting image extension
			$fileName = md5($this->request->image_create->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
			$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
			$contentType = mime_content_type($this->request->image_create->getRealPath());

			if(! in_array($contentType, $allowedMimeTypes) ){
				Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'The uploaded file is not an image') );
				return back()->withInput();
			}
			$this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
			$image_create = $destinationPath . '/' . $fileName;
		} else {
			Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Please upload an image') );
			return back()->withInput();
		}

		try {
			$item = new Staff();
//			dd($this->request->all());
			$item->image_url = $image_create;
			$item->name = $this->request->input('name');
			$item->introduction = $this->request->input('introduction');
			$item->price = $this->request->input('price');
			$item->tel = $this->request->input('tel');
			$item->gender = $this->request->input('gender');
			$item->staff_category_id = $this->request->input('staff_category_id');
//			dd($item);
			$item->save();
			//delete cache redis
//			RedisControl::delete_cache_redis('menus');
//			RedisControl::delete_cache_redis('items');
//			RedisControl::delete_cache_redis('top_items');
			Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Add Staff successfully') );
			return back();
		} catch (\Illuminate\Database\QueryException $e) {
			Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Add Staff fail') );
			return back();
		}
	}

}
