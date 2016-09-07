<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Menus;
use App\Models\Item;
use App\Models\Coupon;

use Modules\Admin\Http\Requests\ImageRequest;

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
        $item_thumbs = $this->item->select('image_url')->orderBy('id','DESC')->take(8)->get();
        $items = $this->item->with(['coupons'=>function($query){$query->select('id','title','start_date','end_date');}])->orderBy('id','DESC')->paginate(12);
        $list_store = $this->store->lists('name','id')->toArray();
        return view('admin::pages.menus.index',compact('item_thumbs','list_store','items'));
    }

    public function create()
    {
        $menus = $this->menu->select('name','id')->get();
        $item_thumbs = $this->item->select('image_url')->orderBy('id','DESC')->take(8)->get();
        $list_coupons = $this->coupon->lists('title','id')->toArray();
        return view('admin::pages.menus.create',compact('menus','item_thumbs','list_coupons'));

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
        if($this->request->has('menu_id')){
            $menu = $this->request->input('menu_id');
            $item->menus()->sync($menu);
            return redirect()->route('admin.menus.index');
        }else{
            return redirect()->route('admin.menus.index');
        }
    }

    public function storeMenu(){
        $all = $this->request->all();
        $this->menu->create($all);
        return redirect()->back();
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
        return view('admin::pages.menus.edit',compact('item_thumbs','menus','list_coupons','item','data_menu'));
    }

    public function update(ImageRequest $imgrequest,$id)
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
            $img_url = $this->request->input('img_bk');
        }

        $item = $this->item->find($id);
        $item->title =$this->request->input('title');
        $item->price =$this->request->input('price');
        $item->description =$this->request->input('description');
        $item->image_url =$img_url;
        $item->coupon_id =$this->request->input('coupon_id');

        $item->save();

        if($this->request->has('menu_id')){
            $menu = $this->request->input('menu_id');
            $item->menus()->sync($menu);
            return redirect()->route('admin.menus.index');
        }else{
            return redirect()->route('admin.menus.index');
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

