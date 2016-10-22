<?php

namespace App\Modules\admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Faq;
use App\Models\FaqType;
use App\Modules\admin\Http\Requests\ImageRequest;
use Notification;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $entity;
    protected $request;
    protected $faqtype;

    public function __construct(Faq $entity, Request $request, FaqType $faqtype){
        $this->entity = $entity;
        $this->request = $request;
        $this->faqtype = $faqtype;
    }


    public function index()
    {
        $data = $this->entity->select('id','question','status','order')->orderBy('order','DESC')->get();
        $type = $this->faqtype->orderBy('id','DESC')->get();
        return view('admin::pages.faq.index',compact('data','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list = $this->faqtype->lists('title','id');
        return view('admin::pages.faq.create',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $order = $this->entity->orderBy('order','DESC')->first();
        count($order) == 0 ?  $current = 1 :  $current = $order->order +1 ;

        $data = [
            'question' => $this->request->input('question'),
            'slug' => \Unicode::make($this->request->input('question')),
            'answer' => $this->request->input('answer'),
            'faqtype_id' => $this->request->input('faqtype_id'),
            'order' => $current,
        ];
        $this->entity->create($data);
        Notification::success('Created');
        return redirect()->route('admin.faq.index');
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
        $list = $this->faqtype->lists('title','id');
        $data = $this->entity->find($id);
        return view('admin::pages.faq.view',compact('data','list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = $this->entity->find($id);
        $data->question = $this->request->input('question');
        $data->slug = \Unicode::make($this->request->input('question'));
        $data->answer = $this->request->input('answer');
        $data->order = $this->request->input('order');
        $data->status = $this->request->has('status') ? '1' : '0';
        $data->faqtype_id = $this->request->input('faqtype_id');
        $data->save();

        Notification::success('Updated');
        return redirect()->route('admin.faq.index');
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
        return redirect()->route('admin.faq.index');
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
        $type = new FaqType;
        $type->title =  $this->request->input('title');
        $type->save();
        Notification::success('FAQ TYPE Created.');
        return redirect()->route('admin.faq.index');
    }

    public function edit_type($id){
        $type = $this->faqtype->find($id);
        $type->title = $this->request->input('title');
        $type->save();
        Notification::success('FAQ TYPE Edited.');
        return redirect()->route('admin.faq.index');
    }
    public function delete_type($id){
        $this->faqtype->destroy($id);
        Notification::success('FAQ TYPE Deleted.');
        return redirect()->route('admin.faq.index');
    }
}
