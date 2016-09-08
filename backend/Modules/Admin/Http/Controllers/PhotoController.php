<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\Store;

use Modules\Admin\Http\Requests\ImageRequest;

class PhotoController extends Controller
{
    protected $photo;
    protected $photocate;
    protected $store;
    protected $request;

    public function __construct(PhotoCat $photocate, Photo $photo, Store $store, Request $request){
    	$this->photocate = $photocate;
    	$this->photo = $photo;
    	$this->store = $store;
    	$this->request = $request;
    }

    public function index()
    {
    	$store_list = $this->store->lists('name','id');
    	$photo = $this->photo->orderBy('id','DESC')->paginate(12);
    	return view('admin::pages.photocats.index',compact('store_list','photo'));
    }

    public function create()
    {
    	$photo = $this->photo->orderBy('id','DESC')->take(12)->get();
    	$photocate_list = $this->photocate->lists('name','id')->toArray();
    	$store_list = $this->store->lists('name','id');
    	return view('admin::pages.photocats.create',compact('photocate_list','photo','store_list'));

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
    	$data = [
    		'photo_category_id' => $this->request->input('photo_category_id'),
    		'image_url' => $img_url,
    	];

    	$this->photo->create($data);

    	return redirect()->route('admin.photo.index');
    }

    public function show($id)
    {
    	$photo = $this->photo->orderBy('id','DESC')->take(12)->get();
    	$photocate_list = $this->photocate->lists('name','id')->toArray();
    	$store_list = $this->store->lists('name','id');
        return view('admin::pages.photocats.edit',compact('photo','store_list','photocate_list'));
    }

    public function edit($id)
    {
    	$photo_all = $this->photo->orderBy('id','DESC')->take(12)->get();
    	$photo = $this->photo->find($id);
    	$photocate_list = $this->photocate->lists('name','id')->toArray();
        return view('admin::pages.photocats.edit',compact('photo','photocate_list','photo_all'));
    }

    public function update(ImageRequest $imgrequest, $id)
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

        $photo = $this->photo->find($id);
        $photo->photo_category_id = $this->request->input('photo_category_id');
        $photo->image_url = $img_url;
        $photo->save();

    	return redirect()->route('admin.photo.index');
    }

    public function destroy($id)
    {
    	$this->photo->destroy($id);
    	return redirect()->back();
    }
}
