<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\Menus;
use App\Models\Item;
use Validator;
use Session;
use Modules\Admin\Http\Requests\ImageRequest;

define('REQUEST_MENU_ITEMS',  3);

class MenusController extends Controller
{
    protected $request;
    protected $entity;

    public function __construct(Request $request, Menus $menus){
        $this->request = $request;
        $this->entity = $menus;
    }
    public function index(Menus $menu,Store $store)
    {
        $stores = $this->request->stores;
        $menus = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_item = [];
        if (count($menus) > 0) {
            $list_menu = $menus->pluck('id')->toArray();
            if (count ($list_menu) > 0) {
                
                $list_item = Item::whereHas('menus', function ($query) use ($list_menu) {
                    $query->where('menu_id', '=', $list_menu[0]);
                })->orderBy('updated_at','desc')->take(REQUEST_MENU_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_item); $i++)
                {
                    if ($list_item[$i]->image_url == null)
                        $list_item[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }
            
        }

        //dd($list_store);
        return view('admin::pages.menus.index',compact('menus','list_item', 'list_store'));
    }

    public function view_more()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $menus = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_item = [];
        if (count($menus) > 0) {
            $list_menu = $menus->pluck('id')->toArray();
            if (count ($list_menu) > 0) {
                $menu_id = $list_menu[$cat];
                $list_item = Item::whereHas('menus', function ($query) use ($menu_id) {
                    $query->where('menu_id', '=', $menu_id);
                })->orderBy('updated_at','desc')->take(REQUEST_MENU_ITEMS)->skip($page_num*REQUEST_MENU_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_item); $i++)
                {
                    if ($list_item[$i]->image_url == null)
                        $list_item[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }
            
        }


        $returnHTML = view('admin::pages.menus.element_item')->with(compact('list_item'))->render();
        return $returnHTML;
    }

    public function nextcat()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $menus = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_item = [];
        if (count($menus) > 0) {
            $list_menu = $menus->pluck('id')->toArray();
            if (count ($list_menu) > 0) {
                $menu_id = $list_menu[$cat];
                $list_item = Item::whereHas('menus', function ($query) use ($menu_id) {
                    $query->where('menu_id', '=', $menu_id);
                })->orderBy('updated_at','desc')->take(REQUEST_MENU_ITEMS)->skip($page_num*REQUEST_MENU_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_item); $i++)
                {
                    if ($list_item[$i]->image_url == null)
                        $list_item[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }
            
        }

        $returnHTML = view('admin::pages.menus.element_item')->with(compact('list_item'))->render();
        return $returnHTML;
    }

    public function nextpreview()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $menus = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
        $list_store = $stores->lists('name','id');
        //dd($menus->pluck('id')->toArray());
        $list_item = [];
        if (count($menus) > 0) {
            $list_menu = $menus->pluck('id')->toArray();
            if (count ($list_menu) > 0) {
                $menu_id = $list_menu[$cat];
                $list_item = Item::whereHas('menus', function ($query) use ($menu_id) {
                    $query->where('menu_id', '=', $menu_id);
                })->orderBy('updated_at','desc')->take(REQUEST_MENU_ITEMS)->skip($page_num*REQUEST_MENU_ITEMS)->get();
                //dd($list_item->toArray());
                for($i = 0; $i < count($list_item); $i++)
                {
                    if ($list_item[$i]->image_url == null)
                        $list_item[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }
            
        }

        $returnHTML = view('admin::pages.menus.element_item_preview')->with(compact('list_item'))->render();
        return $returnHTML;
    }

    public function create()
    {

    }

    public function store()
    {
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
            $this->entity->create($data);
            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Add menu successfully') );
            return redirect()->route('admin.menus.index');
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Add menu fail') );
            return back();
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
            $item = new Item();
            $item->image_url = $image_create;
            $item->title = $this->request->input('title');
            $item->description = $this->request->input('description');
            $item->price = $this->request->input('price');
            $item->item_link = $this->request->input('item_link');

            $item->save();
            $item->menus()->attach($this->request->input('menu_id'));

            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Add item successfully') );
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Add item fail') );
            return back();
        }
    }

    public function show($id)
    {

    }

    public function edit(Store $store, $id)
    {
        $stores = $this->request->stores;
        $menus = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();;
        $list_store = $stores->lists('name','id');

        $item = Item::find($id);

        return view('admin::pages.menus.edit',compact('menus','list_store','item'));
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

            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Update item successfully') );
            return redirect()->route('admin.menus.index');
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Update item fail') );
            return back();
        }
    }

    public function destroy($id)
    {
    	$this->entity->destroy($id);
        return redirect()->back();
    }
}

