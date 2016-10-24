<?php

namespace App\Modules\admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;
use App\Modules\admin\Http\Requests\ImageRequest;
use Notification;

class NewsController extends Controller
{
    protected $entity;
	protected $request;

	public function __construct(News $entity, Request $request){
		$this->entity = $entity;
		$this->request = $request;
	}
    public function index(){
    	$data = $this->entity->select('id','title','content','order','status')->orderBy('order','DESC')->get();
    	// dd($data);
    	return view('admin::pages.news.index',compact('data'));
    }

    public function create()
    {
    	return view('admin::pages.news.create');
    }

    public function store(ImageRequest $imgrequest)
    {
    	if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = "upload/original/news";
            $filename = time().'_'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 150){
                \Image::make($file->getRealPath())->resize(150,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }else{
                $file->move($destinationPath,$filename);
            }

            $img_url = $destinationPath.'/'.$filename;
            $img_alt = \GetNameImage::make('\/',$filename);
        }else{
            $img_url = env('PATH_BACKEND').'/images/no-user-image.gif';
            $img_alt = \GetNameImage::make('\/',$img_url);
        }
        dd($img_alt);

        $order = $this->entity->orderBy('order','DESC')->first();
        count($order) == 0 ?  $current = 1 :  $current = $order->order +1 ;

    	$data = [
    		'title' => $this->request->input('title'),
            'slug' => \Unicode::make($this->request->input('title')),
    		'content' => $this->request->input('content'),
    		'order' => $current,
            'img_url' => $img_url,
    		'img_alt' => $img_alt,
    	];
    	$this->entity->create($data);
    	Notification::success('Created');
    	return redirect()->route('admin.news.index');

    }

    public function edit($id)
    {
    	$data = $this->entity->find($id);
    	return view('admin::pages.news.view',compact('data'));
    }

    public function update(ImageRequest $imgrequest, $id)
    {
    	if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = "upload/original/news";
            $filename = time().'.'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 150){
                \Image::make($file->getRealPath())->resize(150,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }else{
                $file->move($destinationPath,$filename);
            }

            $img_url = $destinationPath.'/'.$filename;
            $img_alt = \GetNameImage::make('\/',$filename);
        }else{
            $img_url = $this->request->input('img-bk');
            $img_alt = \GetNameImage::make('\/',$img_url);
        }
        $data = $this->entity->find($id);
        $data->title = $this->request->input('title');
        $data->slug = \Unicode::make($this->request->input('title'));
        $data->content = $this->request->input('content');
        $data->order = $this->request->input('order');
        $data->img_url = $img_url;
        $data->img_alt = $img_alt;
        $data->status = $this->request->has('status') ? '1' : '0';
        $data->save();

        Notification::success('Updated');
        return redirect()->route('admin.news.index');

    }
    public function destroy($id)
    {
    	$this->entity->destroy($id);
    	return redirect()->back();
    }

    public function status(){
        if($this->request->ajax()){
            $id = $this->request->input('id');
            $status = $this->request->input('status');
            $data=$this->entity->find($id);
            $data->status = $status;
            $data->save();
            return response()->json(['msg'=>'Success']);
        }else{
            Notification::error('Bad Request');
            return redirect()->back();
        }
    }
}
