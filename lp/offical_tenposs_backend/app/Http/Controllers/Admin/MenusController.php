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

    public function view_more()
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

        $data =
        [
            'title'=>$this->request->input('title'),
            'price'=>$this->request->input('price'),
            'description' => $this->request->input('description'),
            'image_url'=>$img_url,
            'coupon_id'=> $this->request->input('coupon_id'),
        ];
        $item = $this->item->create($data);
        //delete cache redis
        RedisControl::delete_cache_redis('items');
        if($this->request->has('menu_id')){
            $menu = $this->request->input('menu_id');
            $item->menus()->sync($menu);
            return redirect()->route('admin.menus.index');
        }else{
            return redirect()->route('admin.menus.index');
        }
    }


    public function storeMenu(){
        $rules = [
            'name' => 'required|unique:menus|Max:255',
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
            $this->menu->create($data);
            //delete cache redis
            RedisControl::delete_cache_redis('menus');
            return redirect()->route('admin.menus.index')->with('status','Create the category successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot create the category');
        }
    }

    public function storeitem()
    {
        $rules = [
            'title' => 'required|Max:255',
            'description' => 'required|Min:6',
            'price' => 'required|numeric',
            'item_link' => 'Url',
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
               return redirect()->back()->withInput()->withErrors('The uploaded file is not an image');
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        } else {
           return redirect()->back()->withInput()->withErrors('Please upload an image');
        }

        try {
            $item = new Item();
            $item->image_url = $image_create;
            $item->title = $this->request->input('title');
            $item->description = $this->request->input('description');
            $item->price = $this->request->input('price');
            $item->item_link = $this->request->input('item_link');

            $item->save();
            $item->menus()->attach($this->request->input('menu_id'));
            //delete cache redis
            RedisControl::delete_cache_redis('menus');
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->route('admin.menus.index')->with('status','Add the item successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot add the item');;
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $item_thumbs = $this->item->select('image_url')->orderBy('id','DESC')->take(8)->get();
        $menus = $this->menu->select('name','id')->get();
        $list_coupons = $this->coupon->lists('title','id')->toArray();

        $item = $this->item->with('menus')->find($id);
        $data_menu = [];
        foreach($item->menus()->get() as $v){
            $data_menu[] = $v->id;
        }
        //size info
        $size_type = DB::table('item_size_types')->get();
        $size_categories = DB::table('item_size_categories')->get();
        $size_value = DB::table('item_sizes')->where('item_id',$id)->get();
//        dd($size_categories);
        return view('admin.pages.menus.edit',compact('item_thumbs','menus','list_coupons','item','data_menu',
            'size_type','size_categories','size_value'));
    }

   

    public function update(ImageRequest $imgrequest, $id)
    {
        $rules = [
            'title' => 'required|Max:255',
            'description' => 'required|Min:6',
            'price' => 'required|numeric',
            'item_link' => 'Url',
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
            $item = Item::find($id);
            $item->title = $this->request->input('title');
            $item->description = $this->request->input('description');
            $item->price = $this->request->input('price');
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
            RedisControl::delete_cache_redis('menus');
            RedisControl::delete_cache_redis('items');
            RedisControl::delete_cache_redis('top_items');
            return redirect()->route('admin.menus.index')->with('status','Update the item successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot update the item');
        }
    }

    public function destroy($id)
    {
        $item = $this->item->find($id);
        $item->menus()->detach();
    	$this->item->destroy($id);
        return redirect()->back();
    }
}

