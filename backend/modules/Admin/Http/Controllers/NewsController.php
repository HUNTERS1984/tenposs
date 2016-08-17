<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ImageRequest;


use Carbon\Carbon;
use App\Models\News;
use App\Models\Store;

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
        $news = $this->entity->orderBy('id','DESC')->paginate(6);
        $list_store = $this->store->lists('name','id');
    	return view('admin::pages.news.index',compact('news','list_store'));
    }

    public function create(){
    	return view('admin::pages.news.create');
    }

    public function store(ImageRequest $imgrequest){
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
        $date = Carbon::now()->toDateString();
    	$data = [
    		'title' => $this->request->input('title'),
            'description' => $this->request->input('description'),
    		'store_id' => $this->request->input('store_id'),
            'date' => $date,
    		'image_url' => $img_url,
    	];
    	$this->entity->create($data);

    	return redirect()->route('admin.news.index');

    }

    public function show($id){}

    public function edit($id){
        $newsAll = $this->entity->orderBy('id','DESC')->get();
    	$news = $this->entity->find($id);
        $list_store = $this->store->lists('name','id');
    	return view('admin::pages.news.edit',compact('news','list_store','newsAll'));
    }

    public function update(ImageRequest $imgrequest, $id){
    	if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = env('UPLOAD_PATH');
            $filename = time().'.'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 300){
                \Image::make($file->getRealPath())->resize(300,null)->save($destinationPath.'/'.$filename);
            }else{
                $file->move($destinationPath,$filename);
            }
            $img_url = $destinationPath.'/'.$filename;
    	}else{
            $img_url = $this->request->input('img_bk');
    	}

        $news = $this->entity->find($id);
        $news->title = $this->request->input('title');
        $news->description = $this->request->input('description');
        $news->store_id = $this->request->input('store_id');
        $news->store_id = $this->request->input('store_id');
        $news->store_id = $this->request->input('store_id');
        $news->image_url = $img_url;
        $news->save();

        return redirect()->route('admin.news.index');
    }

    public function destroy($id){
    	$this->entity->destroy($id);
        return redirect()->route('admin.news.index');
    }
}
