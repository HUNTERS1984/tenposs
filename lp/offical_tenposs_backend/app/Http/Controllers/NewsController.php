<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\News;
use Cache;

class NewsController extends Controller
{
    protected $entity;
    protected $request;
	public function __construct(News $entity, Request $request){
		$this->entity = $entity;
		$this->request = $request;
	}

    public function select_all(){
    	$data = $this->entity->where('status',1)->select('id','title','slug','content','img_url','created_at')->orderBy('order','DESC')->paginate(4);
    	$random_news = $this->entity->where('status',1)->select('id','title','slug')->inRandomOrder()->take(4)->get();
    	$top_news = $this->entity->where('status',1)->select('id','title','slug')->orderBy('view','DESC')->take(4)->get();
    	return view('pages.news',compact('data','random_news','top_news'));
    }

    public function select_detail($id, $slug=null){
    	$user_ip = $this->request->ip();
        $cache  = $user_ip."_".$slug;
        if(!Cache::has($cache)){
            $news = $this->entity->find($id);
            $news->view = $news->view + 1;
            $news->save();

            Cache::put($cache,$news->view,10);
        }
    	$data = $this->entity->select('id','title','content','img_url')->find($id);
        $random_news = $this->entity->select('id','title','slug')->where('status',1)->orderByRaw("RAND()")->take(5)->get();
        $top_news = $this->entity->where('status',1)->select('id','title','slug')->orderBY('view','DESC')->take(5)->get();
    	return view('pages.news_detail',compact('data','random_news','top_news'));
    }
}
