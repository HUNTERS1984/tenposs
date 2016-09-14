<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ImageRequest;


use Carbon\Carbon;
use App\Models\News;
use App\Models\Store;

define('REQUEST_NEWS_ITEMS',  10);

class NewsController extends Controller
{
    protected $entity;
	protected $store;
    protected $request;

	public function __construct(News $news, Request $request, Store $store){
		$this->entity = $news;
        $this->request = $request;
        $this->store = $store;
	}
    public function index(){

        $stores = $this->request->stores;
        $news = array();
        $list_store = array();
        if ($stores != null) {
            $news = $this->entity->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->paginate(REQUEST_NEWS_ITEMS);
            $list_store = $stores->lists('name', 'id');
        }

        //dd($list_store);
    	return view('admin::pages.news.index',compact('news','list_store'));
    }

    public function create(){
    	return view('admin::pages.news.create');
    }

    public function store(ImageRequest $imgrequest){

        if($imgrequest->hasFile('image_create')){
            $file = array('image_create' => $this->request->image_create);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_create->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_create->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $contentType = mime_content_type($this->request->image_create->getRealPath());

            if(! in_array($contentType, $allowedMimeTypes) ){
              return redirect()->back()->withError('The uploaded file is not an image');
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        }else{
            $image_create = env('ASSETS_BACKEND').'/images/wall.jpg';
        }
        $date = Carbon::now()->toDateString();

    	$this->entity = new News();
        $this->entity->title = $this->request->input('title');
        $this->entity->description = $this->request->input('description');
        $this->entity->image_url = $image_create;
        $this->entity->date = $date;
        $this->entity->store_id = intval($this->request->input('store_id'));
        $this->entity->save();

    	return redirect()->route('admin.news.index')->withSuccess('Add a news successfully');

    }

    public function show($id){}

    public function edit($id){
        $newsAll = $this->entity->orderBy('id','DESC')->get();
    	$news = $this->entity->find($id);
        $list_store = $this->store->lists('name','id');
    	return view('admin::pages.news.edit',compact('news','list_store','newsAll'));
    }

    public function update(ImageRequest $imgrequest, $id){
        $image_edit = null;
    	if($imgrequest->hasFile('image_edit')){
            $file = array('image_edit' => $this->request->image_edit);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_edit->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_edit->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $contentType = mime_content_type($this->request->image_edit->getRealPath());

            if(! in_array($contentType, $allowedMimeTypes) ){
              return redirect()->back()->withError('The uploaded file is not an image');
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }

        $news = $this->entity->find($id);
        $news->title = $this->request->input('title');
        $news->description = $this->request->input('description');
        $news->store_id = $this->request->input('store_id');
        if ($image_edit)
            $news->image_url = $image_edit;
        $news->save();

        return redirect()->route('admin.news.index')->withSuccess('Update the news successfully');
    }

    public function destroy($id){
    	$this->entity->destroy($id);
        return redirect()->route('admin.news.index')->withSuccess('Delete the news successfully');
    }
}
