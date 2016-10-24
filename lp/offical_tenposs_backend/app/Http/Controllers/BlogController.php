<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Blog;
use Cache;

class BlogController extends Controller
{
    protected $entity;
	protected $request;
	public function __construct(Blog $entity, Request $request){
		$this->entity = $entity;
        $this->request = $request;
	}

    public function select_all(){
    	$data = $this->entity->select('id','title','slug','content','img_url','created_at')->where('status',1)->orderBy('order','DESC')->paginate(4);
    	$random = $this->entity->select('id','title','slug')->where('status',1)->orderByRaw("RAND()")->take(5)->get();
    	return view('pages.blog',compact('data','random'));
    }

    public function select_detail($id, $slug = null){
        $user_ip = $this->request->ip();
        $cache  = $user_ip."_".$slug;
        if(!Cache::has($cache)){
            $blog = $this->entity->find($id);
            $blog->view = $blog->view + 1;
            $blog->save();

            Cache::put($cache,$blog->view,10);
        }
    	$data = $this->entity->select('id','title','slug','content','img_url')->find($id);
        $random = $this->entity->select('id','title')->where('status',1)->orderByRaw("RAND()")->take(5)->get();
        $view_top = $this->entity->where('status',1)->select('id','title')->orderBY('view','DESC')->take(5)->get();
    	return view('pages.blog_detail',compact('data','random','view_top'));
    }
}
