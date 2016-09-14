<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\PhotoCat;
use App\Models\Photo;
use Modules\Admin\Http\Requests\ImageRequest;
use Session;


define('REQUEST_PHOTO_ITEMS',  3);
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
        $list_photo = array();
        if (count($stores) > 0) {
            $photocat = $this->entity->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();
            $list_store = $stores->lists('name', 'id');
            $list_photo = [];
            if (count($photocat) > 0) {
                $list_photo = Photo::wherePhotoCategoryId($photocat[0]->id)->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->get();
                for ($i = 0; $i < count($list_photo); $i++) {
                    if ($list_photo[$i]->image_url == null)
                        $list_photo[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                }
            }
        }
        //dd($list_photo);
        return view('admin::pages.photocats.index',compact('photocat','list_store', 'list_photo'));
    }

    public function view_more()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();
        $list_store = $stores->lists('name','id');
        $list_photo = [];
        if (count($photocat) > 0 && count($photocat) > $cat) {
            $list_photo = Photo::wherePhotoCategoryId($photocat[$cat]->id)->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->skip($page_num*REQUEST_PHOTO_ITEMS)->get();
            for($i = 0; $i < count($list_photo); $i++)
            {
                if ($list_photo[$i]->image_url == null)
                    $list_photo[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
            }
        }

        $returnHTML = view('admin::pages.photocats.element_photo')->with(compact('list_photo'))->render();
        return $returnHTML;
    }

    public function nextcat()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();
        $list_store = $stores->lists('name','id');
        $list_photo = [];
        if (count($photocat) > 0 && count($photocat) > $cat) {
            $list_photo = Photo::wherePhotoCategoryId($photocat[$cat]->id)->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->skip($page_num*REQUEST_PHOTO_ITEMS)->get();
            for($i = 0; $i < count($list_photo); $i++)
            {
                if ($list_photo[$i]->image_url == null)
                    $list_photo[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
            }
        }

        $returnHTML = view('admin::pages.photocats.element_photo')->with(compact('list_photo'))->render();
        return $returnHTML;
    }

    public function nextpreview()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();
        $list_store = $stores->lists('name','id');
        $list_photo = [];
        if (count($photocat) > 0 && count($photocat) > $cat) {
            $list_photo = Photo::wherePhotoCategoryId($photocat[$cat]->id)->orderBy('updated_at', 'desc')->take(REQUEST_PHOTO_ITEMS)->skip($page_num*REQUEST_PHOTO_ITEMS)->get();
            for($i = 0; $i < count($list_photo); $i++)
            {
                if ($list_photo[$i]->image_url == null)
                    $list_photo[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
            }
        }

        $returnHTML = view('admin::pages.photocats.element_photo_preview')->with(compact('list_photo'))->render();
        return $returnHTML;
    }

    public function create()
    {

    }

    public function store()
    {

        $this->entity = new PhotoCat();
        $this->entity->name = $this->request->input('name');
        $this->entity->store_id = $this->request->input('store_id');
        $this->entity->save();

        return redirect()->route('admin.photo-cate.index')->withSuccess('Add a photo category successfully');
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
                Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'The uploaded file is not an image') );
                return back()->withInput();
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        } else {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Please upload an image') );
            return back()->withInput();
        }

        $photo = new Photo();
        $photo->image_url = $image_create;
        $photo->photo_category_id = $this->request->input('photo_category_id');
        $photo->save();

        return redirect()->route('admin.photo-cate.index')->withSuccess('Add a photo successfully');
    }

    public function show($id)
    {

    }

    public function edit(Store $store,$id)
    {
        $stores = $this->request->stores;
        $photocat = $this->entity->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->get();
        $list_store = $stores->lists('name','id');
        $photo = Photo::find($id);
        return view('admin::pages.photocats.edit',compact('photo','list_store','photocat'));
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
                Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'The uploaded file is not an image') );
                return back()->withInput();
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

            return redirect()->route('admin.photo-cate.index')->withSuccess('Update photo successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Update photo fail') );
            return back();
        }
    }

    public function destroy($id)
    {
    	Photo::destroy($id);
        return redirect()->back();
    }
}
