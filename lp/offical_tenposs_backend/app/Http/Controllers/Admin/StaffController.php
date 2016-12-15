<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffCat;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Utils\RedisControl;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\ImageRequest;

use App\Models\Users;
use Carbon\Carbon;
use DB;

define('REQUEST_STAFF_ITEMS',  9);
class StaffController extends Controller
{
    protected $entity;
    protected $request;
    protected $staffcat;
    protected $staff;
    protected $store;

    public function __construct(Request $request, StaffCat $staffcat,Staff $staff,Store $store){

//      $this->middleware('isAdmin');

        $this->request = $request;
        $this->staffcat = $staffcat;
        $this->staff = $staff;
        $this->store = $store;
    }

    public function index()
    {
        $stores = $this->request->stores;
        $list_staff = array();
        $list_preview_staff = array();
        $list_store = array();
        $staff_cat = array();
        if (count($stores) > 0) {
            $staff_cat = $this->staffcat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;

            $list_store = $stores->lists('name', 'id');
            //dd($menus->pluck('id')->toArray());
            
            if (count($staff_cat) > 0) {
                $list_staff_cat = $staff_cat->pluck('id')->toArray();

                if (count($list_staff_cat) > 0) {

                    $list_staff = Staff::whereIn('staff_category_id',$list_staff_cat)->orderBy('updated_at', 'desc')->paginate(REQUEST_STAFF_ITEMS);

                    for ($i = 0; $i < count($list_staff); $i++) {
                        if ($list_staff[$i]->image_url == null)
                            $list_staff[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    }

                    $list_preview_staff = Staff::where('staff_category_id', '=',$list_staff_cat[0])->orderBy('updated_at', 'desc')->take(REQUEST_STAFF_ITEMS)->get();

                    for ($i = 0; $i < count($list_preview_staff); $i++) {
                        if ($list_preview_staff[$i]->image_url == null)
                            $list_preview_staff[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    }
                }

            }
        }
        //dd($list_store);
        return view('admin.pages.staff.index',compact('staff_cat','list_staff', 'list_preview_staff', 'list_store'));
    }

    public function create()
    {
        $staff_cat = $this->staffcat->select('name','id')->get();
        $staff_thumbs = $this->staff->select('image_url')->orderBy('id','DESC')->take(8)->get();
        return view('admin.pages.staff.create',compact('staff_cat','staff_thumbs'));

    }

    public function store()
    {   
        if ($this->request->image_create != null && $this->request->image_create->isValid()) {

            $file = array('image_create' => $this->request->image_create);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_create->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_create->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
            $contentType = mime_content_type($this->request->image_create->getRealPath());

            if (!in_array($contentType, $allowedMimeTypes)) {
                return redirect()->back()->withInput()->withErrors('アップロードファイルは写真ではありません');
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        } else {
            return redirect()->back()->withInput()->withErrors('写真をアップロードしてください');
        }

        try {
            $message = array(
                'staff_category_id.required' => 'カテゴリが必要です。',
                'name.max' => 'タイトルは255文字以下でなければなりません。',
                'name.required' => 'タイトルが必要です。',
                'introduction.required' => '紹介が必要です。',
                'introduction.min' => '紹介は6文字以上でなければなりません。',
                'price.required' => '価格が必要です。',
                'price.numeric' => '価格の数値が無効です。',
                'tel.required' => '電話番号が必要です。',
                'tel.numeric' => '電話番号の数値が無効です。',
                'gender.required' => '性別が必要です。',
            );

            $rules = [
                'staff_category_id' => 'required',
                'name' => 'required|Max:255',
                'introduction' => 'required',
                'price' => 'required',
                'gender' => 'required',
                'tel' => 'required',
                'birthday' => 'required',
            ];
            $v = Validator::make($this->request->all(),$rules,$message);
            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v);
            }

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
            RedisControl::delete_cache_redis('staff');
            return redirect()->route('admin.staff.index')->with('status','追加しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.staff.index')->withInput()->withErrors('追加に失敗しました');
        }
    }
    public function show($id)
    {

    }

    public function edit($id)
    {
        $staff_cat = $this->staffcat->orderBy('id', 'DESC')->get();;

        $item = $this->staff->find($id);
//      dd($item);
        return view('admin.pages.staff.edit',compact('item','staff_cat'));

    }

    public function update(ImageRequest $imgrequest,$id)
    {
        $image_edit = null;
        if($imgrequest->hasFile('image_edit')){
            $file = array('image_edit' => $this->request->image_edit);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_edit->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_edit->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $contentType = mime_content_type($this->request->image_edit->getRealPath());

            if(! in_array($contentType, $allowedMimeTypes) ){
                return redirect()->back()->withInput()->withErrors('アップロードファイルは写真ではありません');
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }

        try {
            $message = array(
                'staff_category_id.required' => 'カテゴリが必要です。',
                'name.max' => 'タイトルは255文字以下でなければなりません。',
                'name.required' => 'タイトルが必要です。',
                'introduction.required' => '紹介が必要です。',
                'introduction.min' => '紹介は6文字以上でなければなりません。',
                'price.required' => '価格が必要です。',
                'price.numeric' => '価格の数値が無効です。',
                'tel.required' => '電話番号が必要です。',
                'tel.numeric' => '電話番号の数値が無効です。',
                'gender.required' => '性別が必要です。',
            );

            $rules = [
                'staff_category_id' => 'required',
                'name' => 'required|Max:255',
                'introduction' => 'required|Min:6',
                'price' => 'required|numeric',
                'tel' =>'required|numeric',
                'gender' =>'required'
            ];
            $v = Validator::make($this->request->all(),$rules,$message);
            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v);
            }

            $item = Staff::find($id);
            $item->name = $this->request->input('name');
            $item->introduction = $this->request->input('introduction');
            $item->price = $this->request->input('price');
            $item->gender = $this->request->input('gender');
            $item->tel = $this->request->input('tel');
            $item->staff_category_id = $this->request->input('staff_category_id');
            if ($image_edit)
                $item->image_url = $image_edit;

            $item->save();
            //delete cache redis
            RedisControl::delete_cache_redis('staff');
            return redirect()->route('admin.staff.index')->with('status','編集しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('編集に失敗しました');
        }
    }

    public function delete()
    {
        try {
            $id = $this->request->input('itemId');
            $this->staff = $this->staff->find($id);
            if ($this->staff) {
                $this->staff->destroy($id);
                RedisControl::delete_cache_redis('staff');
                return redirect()->route('admin.staff.index')->with('status','削除しました');
            } else {
                return redirect()->back()->withErrors('削除に失敗しました');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('削除に失敗しました');
        }
    }

    public function destroy($id)
    {
        try {
            $this->staff = $this->staff->find($id);
            if ($this->staff) {
                $this->staff->destroy($id);
                RedisControl::delete_cache_redis('staff');
                return redirect()->route('admin.staff.index')->with('status','削除しました');
            } else {
                return redirect()->back()->withErrors('削除に失敗しました');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('削除に失敗しました');
        }
        
    }

    public function nextcat()
    {

        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $staff_cat = $this->staffcat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
        $list_store = $stores->lists('name','id');

        $list_staff = [];
        if (count($staff_cat) > 0) {
            $list_staff_cat = $staff_cat->pluck('id')->toArray();
            if (count ($list_staff_cat) > 0) {
                $staff_category_id = $list_staff_cat[$cat];

                $list_staff = Staff::where('staff_category_id',$staff_category_id)->whereNull('deleted_at')->orderBy('updated_at','desc')->take(REQUEST_STAFF_ITEMS)->skip($page_num*REQUEST_STAFF_ITEMS)->get();

                for($i = 0; $i < count($list_staff); $i++)
                {
                    if ($list_staff[$i]->image_url == null)
                        $list_staff[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }

        }

        $returnHTML = view('admin.pages.staff.element_item')->with(compact('list_staff'))->render();
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
        $staff_cat = $this->staffcat->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_staff = [];
        if (count($staff_cat) > 0) {
            $list_staff_cat = $staff_cat->pluck('id')->toArray();
            if (count ($list_staff_cat) > 0) {
                $staff_category_id = $list_staff_cat[$cat];
                $list_staff = Staff::where('staff_category_id',$staff_category_id)->whereNull('deleted_at')->orderBy('updated_at','desc')->take(REQUEST_STAFF_ITEMS)->skip($page_num*REQUEST_STAFF_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_staff); $i++)
                {
                    if ($list_staff[$i]->image_url == null)
                        $list_staff[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }

        }

        $returnHTML = view('admin.pages.staff.element_item_preview')->with(compact('list_staff'))->render();
        return $returnHTML;
    }

    public function storeCat(){
        $message = array(
            'name.required' => 'カテゴリ名が必要です。',
            'name.unique_with' => 'カテゴリ名は既に存在します。',
        );

        $rules = [
            'name' => 'required|unique_with:staff_categories,store_id|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules, $message);
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
            RedisControl::delete_cache_redis('staff_cat');
            RedisControl::delete_cache_redis('staff');
            return redirect()->route('admin.staff.cat')->with('status','追加しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('追加に失敗しました');
        }
    }

    public function cat()
    {
        $stores = $this->request->stores;
        $list_staff = array();
        $list_store = array();
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $list_staff_cat = StaffCat::orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->with('store')->paginate(REQUEST_STAFF_ITEMS);
        }
        //dd($list_store);
        return view('admin.pages.staff.cat',compact('list_staff_cat', 'list_store'));
    }


    public function editCat($id)
    {   
        $stores = $this->request->stores;
        $list_store = array();

        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $staff_cat = StaffCat::whereId($id)->whereNull('deleted_at')->first();
            if (!$staff_cat)
                return abort(404);
        }
        return view('admin.pages.staff.editcat',compact('staff_cat', 'list_store'));
       
    }

    public function updateCat($id)
    {   
        $message = array(
            'name.required' => 'カテゴリ名が必要です。',
            'name.unique_with' => 'カテゴリ名は既に存在します。',
        );

        $rules = [
            'name' => 'required|unique_with:staff_categories,store_id|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules, $message);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $name = $this->request->input('name');
            $item = StaffCat::find($id);
            $item->name = $name;
            $item->store_id = $this->request->input('store_id');
            $item->save();
            RedisControl::delete_cache_redis('staff_cat');
            RedisControl::delete_cache_redis('staff');
            return redirect()->route('admin.staff.cat')->with('status','編集しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('編集に失敗しました');
        }
    }


    public function deleteCat()
    {
        $del_list = $this->request->data;

        if (!$del_list && count($del_list) < 1 )
        {
            return json_encode(array('status' => 'fail')); 
        }
        try {
            DB::beginTransaction();
            foreach ($del_list as $id) {
                StaffCat::where('id', $id)->update(['deleted_at' => Carbon::now()]);
                Staff::where('staff_category_id', $id)->update(['deleted_at' => Carbon::now()]);
            }
            DB::commit();
            RedisControl::delete_cache_redis('staff_cat');
            RedisControl::delete_cache_redis('staff');
            return json_encode(array('status' => 'success')); 
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return json_encode(array('status' => 'fail')); 
        }

       
    }


    public function storestaff()
    {
        if ($this->request->image_create != null && $this->request->image_create->isValid()) {
            $file = array('image_create' => $this->request->image_create);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_create->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_create->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $contentType = mime_content_type($this->request->image_create->getRealPath());

            if(! in_array($contentType, $allowedMimeTypes) ){
                return redirect()->back()->withInput()->withErrors('アップロードファイルは写真ではありません');
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        } else {
            return redirect()->back()->withInput()->withErrors('写真をアップロードしてください');
        }
       
        try {
            $message = array(
                'staff_category_id.required' => 'カテゴリが必要です。',
                'name.max' => 'タイトルは255文字以下でなければなりません。',
                'name.required' => 'タイトルが必要です。',
                'introduction.required' => '紹介が必要です。',
                'introduction.min' => '紹介は6文字以上でなければなりません。',
                'price.required' => '価格が必要です。',
                'price.numeric' => '価格の数値が無効です。',
                'tel.required' => '電話番号が必要です。',
                'tel.numeric' => '電話番号の数値が無効です。',
                'gender.required' => '性別が必要です。',
            );

            $rules = [
                'name' => 'required|Max:255',
                'introduction' => 'required|Min:6',
                'staff_category_id' => 'required',
                'price' => 'required|numeric',
                'tel' =>'required|numeric',
                'gender' =>'required'
            ];
            $v = Validator::make($this->request->all(),$rules,$message);
            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v);
            }

            $item = new Staff();
//          dd($this->request->all());
            $item->image_url = $image_create;
            $item->name = $this->request->input('name');
            $item->introduction = $this->request->input('introduction');
            $item->price = $this->request->input('price');
            $item->tel = $this->request->input('tel');
            $item->gender = $this->request->input('gender');
            $item->staff_category_id = $this->request->input('staff_category_id');
//          dd($item);
            $item->save();
            RedisControl::delete_cache_redis('staff_cat');
            RedisControl::delete_cache_redis('staff');
            return redirect()->route('admin.staff.index')->with('status','追加しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('追加に失敗しました');
        }
    }

}
