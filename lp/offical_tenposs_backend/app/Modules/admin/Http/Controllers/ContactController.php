<?php

namespace App\Modules\admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    protected $entity;

    public function __construct(Contact $entity){
        $this->entity = $entity;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->entity->select('fullname', 'company','id','viewed','phone')->get();
        return view('admin::pages.contact.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->entity->find($id);
        return view('admin::pages.contact.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->entity->destroy($id);
        return redirect()->route('admin.contact');
    }

    public function status(){
        if($this->request->ajax()){
            $id = $this->request->input('id');
            $viewed = $this->request->input('viewed');
            $data=$this->entity->find($id);
            $data->viewed = $viewed;
            $data->save();
            return response()->json(['msg'=>'Success']);
        }else{
            Notification::error('Bad Request');
            return redirect()->back();
        }
    }
}
