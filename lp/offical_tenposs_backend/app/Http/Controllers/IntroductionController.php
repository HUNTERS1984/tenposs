<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Introduction_type;
use App\Models\Introduction_case;

class IntroductionController extends Controller
{
    protected $entity;
    protected $intro_case;

    public function __construct(Introduction_type $intro_type, Introduction_case $intro_case){
    	$this->entity = $intro_type;
    	$this->intro_case = $intro_case;
    }

    public function select_all()
    {
    	$list = $this->entity->lists('title','id');
    	$idtype = $this->entity->first()->id;
    	$data = $this->intro_case->select('id','title','content','img_url','img_alt')->where('intro_type_id',$idtype)->paginate(9);
    	return view('pages.introduction-case01',compact('data','list'));
    }

    public function loadAjax(Request $request)
    {
    	if($request->ajax()){
    		$idtype = $request->input('id');
    		$data = $this->intro_case->select('id','title','content','img_url','img_alt')->where('intro_type_id',$idtype)->paginate(9);
    		$view = view('ajax.load_introduction01',compact('data'))->render();
    		return response()->json(['msg'=>$view]);
    	}else{
    		return redirect()->back();
    	}
    }
}
