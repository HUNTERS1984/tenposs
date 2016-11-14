<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Utils\RedisControl;
use Illuminate\Http\Request;
use App\Utils\UrlHelper;

use App\Models\Store;
use App\Models\PhotoCat;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\ImageRequest;
use Session;
use DB;
use Carbon\Carbon;

define('REQUEST_PHOTO_ITEMS',  9);
class PhotoCatController extends Controller
{
    protected $request;
    protected $entity;
    protected $photo;

    public function __construct(Request $request, PhotoCat $photocat, Photo $photo){
        $this->request = $request;
        $this->entity = $photocat;
        $this->photo = $photo;
    }

    public function index()
    {
        $stores = $this->request->stores;

        $photocat = array();
        $list_store = array();
        $list_preview_photo = array();
        $list_photo = array();
        if (count($stores) > 0) {
            $photocat = $this->entity->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())
                ->whereNull('deleted_at')->get();
            $list_store = $stores->lists('name', 'id');
            if (count($photocat) > 0) {
                $list_preview_photo = Photo::wherePhotoCategoryId($photocat[0]->id)->whereNull('deleted_at')->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->get();
                for ($i = 0; $i < count($list_preview_photo); $i++) {
                    if ($list_preview_photo[$i]->image_url == null)
                        $list_preview_photo[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    else 
                        $list_preview_photo[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$list_preview_photo[$i]->image_url);
                }
               
                $list_photo = Photo::whereIn('photo_category_id',$photocat->pluck('id'))->whereNull('deleted_at')->orderBy('updated_at', 'desc')->paginate(REQUEST_PHOTO_ITEMS);
                for ($i = 0; $i < count($list_photo); $i++) {
                    if ($list_photo[$i]->image_url == null)
                        $list_photo[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    else 
                        $list_photo[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$list_photo[$i]->image_url);
                }

            }
        }
        //dd($list_photo);
        return view('admin.pages.photocats.index',compact('photocat','list_store', 'list_photo', 'list_preview_photo'));
    }

    public function view_more()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();
        $list_store = $stores->lists('name','id');
        $list_photo = [];
        if (count($photocat) > 0 && count($photocat) > $cat) {
            $list_photo = Photo::wherePhotoCategoryId($photocat[$cat]->id)->whereNull('deleted_at')->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->skip($page_num*REQUEST_PHOTO_ITEMS)->get();
            for($i = 0; $i < count($list_photo); $i++)
            {
                if ($list_photo[$i]->image_url == null)
                    $list_photo[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                else 
                    $list_photo[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$list_photo[$i]->image_url);
            }
        }

        $returnHTML = view('admin.pages.photocats.element_photo')->with(compact('list_photo'))->render();
        return $returnHTML;
    }

    public function nextcat()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())
            ->whereNull('deleted_at')->get();
        $list_store = $stores->lists('name','id');
        $list_photo = [];
        if (count($photocat) > 0 && count($photocat) > $cat) {
            $list_photo = Photo::wherePhotoCategoryId($photocat[$cat]->id)->whereNull('deleted_at')
                ->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->skip($page_num*REQUEST_PHOTO_ITEMS)->get();
            for($i = 0; $i < count($list_photo); $i++)
            {
                if ($list_photo[$i]->image_url == null)
                    $list_photo[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                else 
                    $list_photo[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$list_photo[$i]->image_url);
            }
        }

        $returnHTML = view('admin.pages.photocats.element_photo')->with(compact('list_photo'))->render();
        return $returnHTML;
    }

    public function nextpreview()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())
            ->whereNull('deleted_at')->get();
        $list_store = $stores->lists('name','id');
        $list_photo = [];
        if (count($photocat) > 0 && count($photocat) > $cat) {
            $list_photo = Photo::wherePhotoCategoryId($photocat[$cat]->id)->whereNull('deleted_at')
                ->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->skip($page_num*REQUEST_PHOTO_ITEMS)->get();
            for($i = 0; $i < count($list_photo); $i++)
            {
                if ($list_photo[$i]->image_url == null)
                    $list_photo[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                else 
                    $list_photo[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'),$list_photo[$i]->image_url);
            }
        }

        $returnHTML = view('admin.pages.photocats.element_photo_preview')->with(compact('list_photo'))->render();
        return $returnHTML;
    }

    public function create()
    {

    }

    public function store()
    {
        $rules = [
            'name' => 'required|unique:photo_categories|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $this->entity = new PhotoCat();
            $this->entity->name = $this->request->input('name');
            $this->entity->store_id = $this->request->input('store_id');
            //delete cache
            RedisControl::delete_cache_redis('photo_cat',$this->request->input('store_id'));
            $this->entity->save();
            
            return redirect()->route('admin.photo-cate.cat')->with('status','Create the category successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot create the category');
        }
    }

    public function cat()
    {
        $stores = $this->request->stores;
        $list_photo_cat = array();
        $list_store = array();
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $list_photo_cat = PhotoCat::orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->with('store')->paginate(REQUEST_PHOTO_ITEMS);
        }
        //dd($list_store);
        return view('admin.pages.photocats.cat',compact('list_photo_cat', 'list_store'));
    }


    public function editCat($id)
    {   
        $stores = $this->request->stores;
        $list_store = array();

        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $photo_cat = PhotoCat::find($id);
        }
        return view('admin.pages.photocats.editcat',compact('photo_cat', 'list_store'));
       
    }

    public function updateCat($id)
    {   
        $rules = [
            'name' => 'required|unique:photo_categories|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $name = $this->request->input('name');
            $item = PhotoCat::find($id);
            $item->name = $name;
            $item->store_id = $this->request->input('store_id');
            $item->save();

            return redirect()->route('admin.photo-cate.cat')->with('status','Update the category successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot update the category');
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
                PhotoCat::where('id', $id)->update(['deleted_at' => Carbon::now()]);
                Photo::where('photo_category_id', $id)->update(['deleted_at' => Carbon::now()]);
            }
            DB::commit();
            return json_encode(array('status' => 'success')); 
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return json_encode(array('status' => 'fail')); 
        }

       
    }


    public function storephoto()
    {
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
            $photo = new Photo();
            $photo->image_url = $image_create;
            $photo->photo_category_id = $this->request->input('photo_category_id');
            $photo->save();
            //delete cache
            RedisControl::delete_cache_redis('photos',0,$this->request->input('photo_category_id'));
            RedisControl::delete_cache_redis('top_photos');
            return redirect()->route('admin.photo-cate.index')->with('status','Add the photo successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot create the photo');
        }

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();
        $list_store = $stores->lists('name','id');
        $photo = Photo::find($id);
        return view('admin.pages.photocats.edit',compact('photo','list_store','photocat'));
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
                return redirect()->back()->withInput()->withErrors('The uploaded file is not an image');
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }
        
        try {
            $photo = Photo::find($id);
            //dd($photo); die();
            $photo->photo_category_id = $this->request->input('photo_category_id');
            if ($image_edit)
                $photo->image_url = $image_edit;
            $photo->save();
            //delete cache
            RedisControl::delete_cache_redis('photos',0,$this->request->input('photo_category_id'));
            RedisControl::delete_cache_redis('top_photos');

            return redirect()->route('admin.photo-cate.index')->with('status','Update the photo successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot update the photo');
        }
    }

    public function destroy($id)
    {
        try {
            $this->photo = $this->photo->find($id);
            if ($this->photo) {
                $this->photo->destroy($id);
                return redirect()->route('admin.photo-cate.index')->with('status','Delete the photo successfully');
            } else {
                return redirect()->back()->withErrors('Cannot delete the photo');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot delete the photo');
        }
    }
}
