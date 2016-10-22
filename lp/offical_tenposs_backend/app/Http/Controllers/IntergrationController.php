<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Intergration;
use Cache;

class IntergrationController extends Controller
{
    protected $entity;
    protected $request;
	public function __construct(Intergration $entity, Request $request){
		$this->entity = $entity;
		$this->request = $request;
	}

    public function select_all(){
    	$data = $this->entity->where('status',1)->select('id','title','slug','img_url','content')->orderBy('order','DESC')->paginate(4);
    	
    	return view('pages.intergration02',compact('data'));
    }

    public function select_detail($id, $slug = null){
    	$user_ip = $this->request->ip();
        $cache  = $user_ip."_".$slug;
        if(!Cache::has($cache)){
            $intergration02 = $this->entity->find($id);
            $intergration02->view = $intergration02->view + 1;
            $intergration02->save();
            Cache::put($cache,$intergration02->view,10);
        }
    	$data = $this->entity->select('id','title','slug','content','img_url')->find($id);
    	return view('pages.intergration02_detail',compact('data'));
    }
}
