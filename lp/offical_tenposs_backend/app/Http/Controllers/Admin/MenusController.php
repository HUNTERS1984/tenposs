<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Utils\RedisControl;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Menus;
use App\Models\Item;
use App\Models\Coupon;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Http\Requests\ImageRequest;
use Validator;
use Session;
use Carbon\Carbon;


define('REQUEST_MENU_ITEMS',  9);

class MenusController extends Controller
{
    protected $request;
    protected $menu;
    protected $item;
    protected $coupon;
    protected $store;

    public function __construct(Request $request, Menus $menus, Item $item, Coupon $coupon, Store $store){
        $this->request = $request;
        $this->menu = $menus;
        $this->item = $item;
        $this->coupon = $coupon;
        $this->store = $store;
    }
    public function index()
    {
        $stores = $this->request->stores;
        $menus = array();
        $list_item = array();
        $list_store = array();
        if (count($stores) > 0) {
            $menus = $this->menu->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
            $list_store = $stores->lists('name', 'id');
            //dd($menus->pluck('id')->toArray());
            $list_item = [];
            if (count($menus) > 0) {
                $list_menu = $menus->pluck('id')->toArray();
                if (count($list_menu) > 0) {

                    $list_preview_item = Item::whereHas('menus', function ($query) use ($list_menu) {
                        $query->where('menu_id', '=', $list_menu[0]);
                    })->whereNull('deleted_at')->orderBy('updated_at', 'desc')->take(REQUEST_MENU_ITEMS)->get();

                    $list_item = Item::whereHas('menus', function ($query) use ($list_menu) {
                        $query->whereIn('menu_id',$list_menu);
                    })->whereNull('deleted_at')->orderBy('updated_at', 'desc')->paginate(REQUEST_MENU_ITEMS);

                    //dd($list_item->toArray());
                    for ($i = 0; $i < count($list_preview_item); $i++) {
                        if ($list_preview_item[$i]->image_url == null)
                            $list_preview_item[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    }

                    for ($i = 0; $i < count($list_item); $i++) {
                        if ($list_item[$i]->image_url == null)
                            $list_item[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    }
                }

            }
        }
        //dd($list_store);
        return view('admin.pages.menus.index',compact('menus','list_item','list_preview_item', 'list_store'));
    }

    public function cat()
    {
        $stores = $this->request->stores;
        $menus = array();
        $list_store = array();
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $menus = $this->menu->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->with('store')->paginate(REQUEST_MENU_ITEMS);
        }
        //dd($list_store);
        return view('admin.pages.menus.cat',compact('menus', 'list_store'));
    }


    public function editCat($menu_id)
    {   
        $stores = $this->request->stores;
        $list_store = array();
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $menu = $this->menu->whereId($menu_id)->whereNull('deleted_at')->first();
            if (!$menu)
                return abort(404);
        }
        return view('admin.pages.menus.editcat',compact('menu', 'list_store'));
       
    }

    public function updateCat($menu_id)
    {   
        $message = array(
            'name.required' => 'カテゴリ名が必要です。',
            'name.unique_with' => 'カテゴリ名は既に存在します。',
        );

        $rules = [
            'name' => 'required|unique_with:menus,store_id|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules, $message);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $name = $this->request->input('name');
            $item = Menus::find($menu_id);
            $item->name = $name;
            $item->store_id = $this->request->input('store_id');
            $item->save();
            RedisControl::delete_cache_redis('menus');
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->route('admin.menus.cat')->with('status','編集しました');
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
                Menus::where('id', $id)->update(['deleted_at' => Carbon::now()]);
                $list_id = Menus::find($id)->items()->get()->pluck('id')->toArray();
                Item::whereIn('id', $list_id)->update(['deleted_at' => Carbon::now()]);
            }
            DB::commit();
            RedisControl::delete_cache_redis('menus');
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return json_encode(array('status' => 'success')); 
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return json_encode(array('status' => 'fail')); 
        }

       
    }

    public function nextcat()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $menus = $this->menu->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_item = [];
        if (count($menus) > 0) {
            $list_menu = $menus->pluck('id')->toArray();
            if (count ($list_menu) > 0) {
                $menu_id = $list_menu[$cat];
                $list_item = Item::whereHas('menus', function ($query) use ($menu_id) {
                    $query->where('menu_id', '=', $menu_id);
                })->whereNull('deleted_at')->orderBy('updated_at','desc')->take(REQUEST_MENU_ITEMS)->skip($page_num*REQUEST_MENU_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_item); $i++)
                {
                    if ($list_item[$i]->image_url == null)
                        $list_item[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }
            
        }

        $returnHTML = view('admin.pages.menus.element_item')->with(compact('list_item'))->render();
        return $returnHTML;
    }

    public function nextpreview()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $menus = $this->menu->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_item = [];
        if (count($menus) > 0) {
            $list_menu = $menus->pluck('id')->toArray();
            if (count ($list_menu) > 0) {
                $menu_id = $list_menu[$cat];
                $list_item = Item::whereHas('menus', function ($query) use ($menu_id) {
                    $query->where('menu_id', '=', $menu_id);
                })->whereNull('deleted_at')->orderBy('updated_at','desc')->take(REQUEST_MENU_ITEMS)->skip($page_num*REQUEST_MENU_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_item); $i++)
                {
                    if ($list_item[$i]->image_url == null)
                        $list_item[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }
            
        }

        $returnHTML = view('admin.pages.menus.element_item_preview')->with(compact('list_item'))->render();
        return $returnHTML;
    }

    public function create()
    {
        $menus = $this->menu->select('name','id')->get();
        $item_thumbs = $this->item->select('image_url')->orderBy('id','DESC')->take(8)->get();
        $list_coupons = $this->coupon->lists('title','id')->toArray();
        return view('admin.pages.menus.create',compact('menus','item_thumbs','list_coupons'));

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

        try {
            $message = array(
                'coupon_type_id.required' => 'カテゴリが必要です。',
                'title.max' => 'タイトルは255文字以下でなければなりません。',
                'title.required' => 'タイトルが必要です。',
                'description.required' => '説明が必要です。',
                'description.min' => '説明は6文字以上でなければなりません。',
                'price.required' => '価格が必要です。',
                'price.numeric' => '価格の数値が無効です。',
                'item_link.active_url' => 'URLの形式が無効です。',
            );

            $rules = [
                'menu_id' => 'required',
                'title' => 'required|Max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'item_link' => 'active_url',
            ];
            $v = Validator::make($this->request->all(),$rules, $message);
            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v);
            }

            $data =
            [
                'title'=>$this->request->input('title'),
                'price'=>str_replace('.', '', $this->request->input('price')),
                'description' => $this->request->input('description'),
                'image_url'=>$img_url,
                'coupon_id'=> $this->request->input('coupon_id'),
            ];
            $item = $this->item->create($data);
            //delete cache redis
            RedisControl::delete_cache_redis('items');
            $menu = $this->request->input('menu_id');
            $item->menus()->sync($menu);
            return redirect()->route('admin.menus.index')->with('status','追加しました'); 
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('追加に失敗しました');
        }
    }


    public function storeMenu(){
        
        $message = array(
            'name.required' => 'カテゴリ名が必要です。',
            'name.unique_with' => 'カテゴリ名は既に存在します。',
        );

        $rules = [
            'name' => 'required|unique_with:menus,store_id|Max:255',
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
            $this->menu->create($data);
            //delete cache redis
            RedisControl::delete_cache_redis('menus');
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->back()->with('status','追加しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('追加に失敗しました');
        }
    }

    public function storeitem()
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
                'coupon_type_id.required' => 'カテゴリが必要です。',
                'title.max' => 'タイトルは255文字以下でなければなりません。',
                'title.required' => 'タイトルが必要です。',
                'description.required' => '説明が必要です。',
                'description.min' => '説明は6文字以上でなければなりません。',
                'price.required' => '価格が必要です。',
                'price.numeric' => '価格の数値が無効です。',
                'item_link.active_url' => 'URLの形式が無効です。',
            );

            $rules = [
                'menu_id' => 'required',
                'title' => 'required|Max:255',
                'description' => 'required|Min:6',
                'price' => 'required|numeric',
                'item_link' => 'active_url',
            ];
            $v = Validator::make($this->request->all(),$rules, $message);
            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v);
            }

            $item = new Item();
            $item->image_url = $image_create;
            $item->title = $this->request->input('title');
            $item->description = $this->request->input('description');
            $item->price = str_replace('.', '', $this->request->input('price'));
            $item->item_link = $this->request->input('item_link');

            $item->save();
            $item->menus()->attach($this->request->input('menu_id'));
            //delete cache redis
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->route('admin.menus.index')->with('status','追加しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('追加に失敗しました');;
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $item = Item::whereId($id)->with('menus')->first();

        if ($item) {
            $menu_id = 0;
            $stores = $this->request->stores;
            $menus = array();
            if (count($stores) > 0) {
                $list_store = $stores->lists('name', 'id');
                $menus = $this->menu->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->with('store')->select('name','id')->get();
            }
            foreach ($item->menus as $menu_item) {
                if (in_array($menu_item->id, $menus->pluck('id')->toArray())) {
                    $menu_id = $menu_item->id;
                    break;
                }
            }
            //size info
            $size_type = DB::table('item_size_types')->get();
            $size_categories = DB::table('item_size_categories')->get();
            $size_value = DB::table('item_sizes')->where('item_id',$id)->get();
    //        dd($size_categories);
            return view('admin.pages.menus.edit',compact('menus','item', 'menu_id',
                'size_type','size_categories','size_value'));
        } else {
            abort(404);
        }
       
    }

   

    public function update(ImageRequest $imgrequest, $id)
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
                Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'アップロードファイルは写真ではありません') );
                return back()->withInput();
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }

        try {

            $message = array(
                'coupon_type_id.required' => 'カテゴリが必要です。',
                'title.max' => 'タイトルは255文字以下でなければなりません。',
                'title.required' => 'タイトルが必要です。',
                'description.required' => '説明が必要です。',
                'description.min' => '説明は6文字以上でなければなりません。',
                'price.required' => '価格が必要です。',
                'price.numeric' => '価格の数値が無効です。',
                'item_link.active_url' => 'URLの形式が無効です。',
            );

            $rules = [
                'menu_id' => 'required',
                'title' => 'required|Max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'item_link' => 'active_url',
            ];
            $v = Validator::make($this->request->all(),$rules,$message);
            if ($v->fails())
            {
                return redirect()->back()->withInput()->withErrors($v);
            }

            $item = Item::find($id);
            $item->title = $this->request->input('title');
            $item->description = $this->request->input('description');
            $item->price = str_replace('.', '', $this->request->input('price'));
            $item->item_link = $this->request->input('item_link');
            if ($image_edit)
                $item->image_url = $image_edit;

            $item->save();

            $item->menus()->detach();
            $item->menus()->attach($this->request->input('menu_id'));

            //delete size info
            $arr_size_value = $this->request->input('size_value');
            if (count($arr_size_value) > 0) {
                $size_type = DB::table('item_size_types')->get();
                $arr_insert =[];
                foreach ($size_type as $item)
                {
                    $item_detail = $arr_size_value[$item->id];
                    $size_categories = DB::table('item_size_categories')->get();
                    foreach ($size_categories as $item_cate)
                    {
                        $arr_insert[] = array('item_id' => $id, 'item_size_type_id'=>$item->id,
                            'item_size_category_id' => $item_cate->id,'value' => $item_detail[$item_cate->id]);
                     }
                }
                if (count($arr_insert) > 0) {
                    DB::table('item_sizes')->where('item_id', $id)->delete();
                    DB::table('item_sizes')->insert($arr_insert);
                }
            }
            //delete cache redis
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->route('admin.menus.index')->with('status','編集しました');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('編集に失敗しました');
        }
    }

    public function delete()
    {
        try {
            $id = $this->request->input('itemId');
            $item = $this->item->find($id);
            if ($item) {
                $item->menus()->detach();
                $item->destroy($id);
                RedisControl::delete_cache_redis('items');
                RedisControl::delete_cache_redis('top_items');
                return redirect()->route('admin.menus.index')->with('status','削除しました');
            } else {
                return redirect()->back()->withErrors('削除に失敗しました');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('削除に失敗しました');
        }
    }

    public function destroy($id)
    {
        $item = $this->item->find($id);
        if ($item) {
            $item->menus()->detach();
        	$item->destroy($id);
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->route('admin.menus.index')->with('status','削除しました');
        }
        return redirect()->back();
    }
}

