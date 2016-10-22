<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Partnership;
use Cache;



class PartnershipController extends Controller
{
    protected $entity;
    protected $request;
	public function __construct(Partnership $entity, Request $request){
		$this->entity = $entity;
		$this->request = $request;
	}

    public function select_all(){
    	$data = $this->entity->select('id','title','slug','content','img_url')->orderBy('order','DESC')->paginate(6);
    	return view('pages.partnership02',compact('data'));
    }

    public function select_detail($id, $slug = null)
    {
    	$user_ip = $this->request->ip();
        $cache  = $user_ip."_".$slug;
        if(!Cache::has($cache)){
            $partnership02 = $this->entity->find($id);
            $partnership02->view = $partnership02->view + 1;
            $partnership02->save();
            Cache::put($cache,$partnership02->view,10);
        }
    	$data = $this->entity->select('id','title','slug','content','img_url')->find($id);
    	return view('pages.partnership02_detail',compact('data'));
    }
}
