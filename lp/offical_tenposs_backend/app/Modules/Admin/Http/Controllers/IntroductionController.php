<?php

namespace App\Modules\admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Introduction_case;
use App\Models\Introduction_type;
use App\Modules\admin\Http\Requests\ImageRequest;
use Notification;

class IntroductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $entity;
    protected $request;
    protected $intro_type;

    public function __construct(Introduction_case $entity, Request $request, Introduction_type $intro_type){
        $this->entity = $entity;
        $this->request = $request;
        $this->intro_type = $intro_type;
    }


    public function index()
    {
        $data = $this->entity->select('id','title','status','order')->orderBy('order','DESC')->get();
        $type = $this->intro_type->orderBy('id','DESC')->get();
        return view('admin::pages.introduction.index',compact('data','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list = $this->intro_type->lists('title','id');
        return view('admin::pages.introduction.create',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $imgrequest)
    {
    	if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = 'upload/original/introduction';
            $filename = time().'_'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 160){
                \Image::make($file->getRealPath())->resize(160,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
            }else{
                $file->move($destinationPath,$filename);
            }

            $img_url = $destinationPath.'/'.$filename;
            $img_alt = \GetNameImage::make('\/',$filename);
        }else{
            $img_url = env('PATH_BACKEND').'/images/no-user-image.gif';
            $img_alt = \GetNameImage::make('\/',$img_url);
        }

        $order = $this->entity->orderBy('order','DESC')->first();
        count($order) == 0 ?  $current = 1 :  $current = $order->order +1 ;

        $data = [
            'title' => $this->request->input('title'),
            'slug' => \Unicode::make($this->request->input('question')),
            'content' => $this->request->input('content'),
            'img_url' => $img_url,
            'img_alt' => $img_alt,
            'intro_type_id' => $this->request->input('intro_type_id'),
            'order' => $current,
        ];
        $this->entity->create($data);
        Notification::success('Created');
        return redirect()->route('admin.introduction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = $this->intro_type->lists('title','id');
        $data = $this->entity->find($id);
        return view('admin::pages.introduction.view',compact('data','list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $imgrequest, $id)
    {
        if($imgrequest->hasFile('img')){
            $file = $imgrequest->file('img');
            $destinationPath = "upload/original/introduction";
            $filename = time().'.'.$file->getClientOriginalName();

            $size = getimagesize($file);
            if($size[0] > 160){
                \Image::make($file->getRealPath())->resize(160,null,function($constraint){$constraint->aspectRatio();})->save($destinationPath.'/'.$filename);
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
        $data->status = $this->request->has('status') ? '1' : '0';
        $data->intro_type_id = $this->request->input('intro_type_id');
        $data->img_url = $img_url;
        $data->img_alt = $img_alt;
        $data->save();

        Notification::success('Updated');
        return redirect()->route('admin.introduction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->entity->destroy($id);
        Notification::success('Deleted');
        return redirect()->route('admin.introduction.index');
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

    public function add_type(){
        $type = new Introduction_type;
        $type->title =  $this->request->input('title');
        $type->save();
        Notification::success('Introduction Type Created.');
        return redirect()->route('admin.introduction.index');
    }

    public function edit_type($id){
        $type = $this->intro_type->find($id);
        $type->title = $this->request->input('title');
        $type->save();
        Notification::success('Introduction Type Edited.');
        return redirect()->route('admin.introduction.index');
    }
    public function delete_type($id){
        $this->intro_type->destroy($id);
        Notification::success('Introduction Type Deleted.');
        return redirect()->route('admin.introduction.index');
    }
}
