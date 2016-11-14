<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\NewsCat;
use App\Utils\HttpRequestUtil;
use App\Utils\RedisControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\ImageRequest;


use Carbon\Carbon;
use App\Models\News;
use App\Models\Store;
use Session;
use Log;
use DB;

define('REQUEST_NEWS_ITEMS', 10);

class NewsController extends Controller
{
    protected $entity;
    protected $store;
    protected $request;
    protected $new_cat;

    public function __construct(News $news, Request $request, Store $store,NewsCat $newsCat)
    {
        $this->entity = $news;
        $this->request = $request;
        $this->store = $store;
        $this->new_cat = $newsCat;
    }

    public function index()
    {

        $stores = $this->request->stores;
        $news = array();
        $list_store = array();
        $news_cat = array();
        if ($stores != null) {
            $news_cat = $this->new_cat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())
                ->whereNull('deleted_at')->get();
            if (count($news_cat) > 0) {
                $list_news_cat = $news_cat->pluck('id')->toArray();

                if (count($list_news_cat) > 0) {
                    $news = News::whereIn('new_category_id',$list_news_cat)->whereNull('deleted_at')->orderBy('date', 'desc')->paginate(REQUEST_NEWS_ITEMS);
                    for ($i = 0; $i < count($news); $i++) {
                        if ($news[$i]->image_url == null)
                            $news[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    }
                    $list_preview_news = News::where('new_category_id', '=',$list_news_cat[0]) ->whereNull('deleted_at')->orderBy('date', 'desc')->take(REQUEST_NEWS_ITEMS)->get();

                    for ($i = 0; $i < count($list_preview_news); $i++) {
                        if ($list_preview_news[$i]->image_url == null)
                            $list_preview_news[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                    }
                }
            }
            $list_store = $stores->lists('name', 'id');
        }
        return view('admin.pages.news.index', compact('news', 'list_store','news_cat','list_preview_news'));
    }

    public function create()
    {
        $new_cat = $this->new_cat->select('name','id')->get();
        return view('admin.pages.news.create',compact('new_cat'));
    }

    public function store(Request $request, ImageRequest $imgrequest)
    {

        if ($imgrequest->hasFile('image_create')) {
            $file = array('image_create' => $this->request->image_create);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_create->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_create->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
            $contentType = mime_content_type($this->request->image_create->getRealPath());

            if (!in_array($contentType, $allowedMimeTypes)) {
                return redirect()->back()->withInput()->withErrors('The uploaded file is not an image');
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        } else {
            return redirect()->back()->withInput()->withErrors('Please upload an image');
        }
        $date = Carbon::now()->toDateString();

        $this->entity = new News();
        $this->entity->title = $this->request->input('title');
        $this->entity->description = $this->request->input('description');
        $this->entity->image_url = $image_create;
        $this->entity->date = $date;
        $this->entity->new_category_id = intval($this->request->input('new_category_id'));
        $this->entity->save();
        RedisControl::delete_cache_redis('news', intval($this->request->input('new_category_id')));
        //push notify to all user on app
        $app_data = App::where('user_id', Session::get('user')->id )->first();
        $data_push = array(
            'app_id' => $app_data->id,
            'type' => 'news',
            'data_id' => $this->entity->id,
            'data_title' => '',
            'data_value' => '',
            'created_by' => Session::get('user')->email
        );
        $push = HttpRequestUtil::getInstance()->post_data_return_boolean(Config::get('api.url_api_notification_app_id'), $data_push);
       
        //if (!$push)
            //Log::info('push fail: ' . json_decode($data_push));
        //end push
        return redirect()->route('admin.news.index')->with('status','Add a news successfully');

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $newsAll = $this->entity->orderBy('id', 'DESC')->get();
        $news = $this->entity->find($id);
        $list_store = $this->store->lists('name', 'id');
        $new_cat = $this->new_cat->select('name','id')->get();
        return view('admin.pages.news.edit', compact('news', 'list_store', 'newsAll','new_cat'));
    }

    public function update(ImageRequest $imgrequest, $id)
    {
        $image_edit = null;
        if ($imgrequest->hasFile('image_edit')) {
            $file = array('image_edit' => $this->request->image_edit);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_edit->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_edit->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
            $contentType = mime_content_type($this->request->image_edit->getRealPath());

            if (!in_array($contentType, $allowedMimeTypes)) {
                return redirect()->back()->withInput()->withErrors('The uploaded file is not an image');
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }

        $news = $this->entity->find($id);
        $news->title = $this->request->input('title');
        $news->description = $this->request->input('description');
        $news->new_category_id = $this->request->input('new_category_id');
        if ($image_edit)
            $news->image_url = $image_edit;
        $news->save();
        RedisControl::delete_cache_redis('news', intval($this->request->input('new_category_id')));
        RedisControl::delete_cache_redis('top_news', intval($this->request->input('new_category_id')));
        return redirect()->route('admin.news.index')->with('status','Up the news successfully');
    }

    public function destroy($id)
    {
//        $this->entity->destroy($id);
        News::where('id', $id)->update(['deleted_at' => Carbon::now()]);
        return redirect()->route('admin.news.index')->with('status','Delete the news successfully');
    }

    public function storeCat(){
        $rules = [
            'name' => 'required|unique:new_categories|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $data = [
                'name' => $this->request->input('name'),
                'store_id' => $this->request->input('store_id'),
            ];
            $this->new_cat->create($data);
            //delete cache redis
            RedisControl::delete_cache_redis('news_cat');
            return redirect()->route('admin.news.cat')->with('status','Create the category successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot create the category');
        }

    }

    public function nextcat()
    {

        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $news_cat = $this->new_cat->orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
//        $list_store = $stores->lists('name','id');

        $list_news = [];
        if (count($news_cat) > 0) {
            $list_new_cat = $news_cat->pluck('id')->toArray();
            if (count ($list_new_cat) > 0) {
                $new_category_id = $list_new_cat[$cat];

                $list_news = News::where('new_category_id',$new_category_id)->whereNull('deleted_at')->orderBy('date','desc')->take(REQUEST_NEWS_ITEMS)->skip($page_num*REQUEST_NEWS_ITEMS)->get();

                for($i = 0; $i < count($list_news); $i++)
                {
                    if ($list_news[$i]->image_url == null)
                        $list_news[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }

        }

        $returnHTML = view('admin.pages.news.element_item')->with(compact('list_news'))->render();
        return $returnHTML;
    }

    public function nextpreview()
    {
        $page_num = $this->request->page;
        $cat = $this->request->cat;

        $stores = $this->request->stores;
        $news_cat = $this->new_cat->orderBy('id','DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->get();;
//        $list_store = $stores->lists('name','id');
        //dd($news->pluck('id')->toArray());
        $list_news = [];
        if (count($news_cat) > 0) {
            $list_news_cat = $news_cat->pluck('id')->toArray();
            if (count ($list_news_cat) > 0) {
                $news_category_id = $list_news_cat[$cat];
                $list_news = News::where('new_category_id',$news_category_id)->whereNull('deleted_at')->orderBy('date','desc')->take(REQUEST_NEWS_ITEMS)->skip($page_num*REQUEST_NEWS_ITEMS)->get();
//                dd($list_news->toArray());
                for($i = 0; $i < count($list_news); $i++)
                {
                    if ($list_news[$i]->image_url == null)
                        $list_news[$i]->image_url = env('ASSETS_BACKEND').'/images/wall.jpg';
                }
            }

        }

        $returnHTML = view('admin.pages.news.element_item_preview')->with(compact('list_news'))->render();
        return $returnHTML;
    }

    public function cat()
    {
        $stores = $this->request->stores;
        $list_news = array();
        $list_store = array();
        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $list_news_cat = NewsCat::orderBy('id', 'DESC')->whereIn('store_id', $stores->pluck('id')->toArray())->whereNull('deleted_at')->with('store')->paginate(REQUEST_NEWS_ITEMS);
        }
        //dd($list_store);
        return view('admin.pages.news.cat',compact('list_news_cat', 'list_store'));
    }


    public function editCat($id)
    {   
        $stores = $this->request->stores;
        $list_store = array();

        if (count($stores) > 0) {
            $list_store = $stores->lists('name', 'id');
            $news_cat = NewsCat::find($id);
        }
        return view('admin.pages.news.editcat',compact('news_cat', 'list_store'));
       
    }

    public function updateCat($id)
    {   
        $rules = [
            'name' => 'required|unique:new_categories|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $name = $this->request->input('name');
            $item = NewsCat::find($id);
            $item->name = $name;
            $item->store_id = $this->request->input('store_id');
            $item->save();

            return redirect()->route('admin.news.cat')->with('status','Update the category successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot update the category');
        }
    }


    public function deleteCat()
    {
        $del_list = $this->request->data;

        if (!$del_list && count($del_list) < 1 )
        {
            return json_encode(array('status' => 'fail')); 
        }
        try {
            DB::beginTransaction();
            foreach ($del_list as $id) {
                NewsCat::where('id', $id)->update(['deleted_at' => Carbon::now()]);
                News::where('new_category_id', $id)->update(['deleted_at' => Carbon::now()]);
            }
            DB::commit();
            return json_encode(array('status' => 'success')); 
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return json_encode(array('status' => 'fail')); 
        }

       
    }


}
