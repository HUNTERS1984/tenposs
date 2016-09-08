<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Store;
use App\Models\App;
use App\Models\Coupon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\CouponType;
use Auth;
use Session;
use App\Jobs\InstagramHashtagJob;
use DB;
use Validator;

define('REQUEST_COUPON_ITEMS',  5);

class CouponController extends Controller
{
    protected $request;
    protected $entity;
    protected $type;

    public function __construct(Request $request, Coupon $coupon, CouponType $type){
        $this->request = $request;
        $this->entity = $coupon;
        $this->type = $type;
    }
    public function index()
    {
        $list_store = $this->request->stores;
        $list_coupon_type = $this->type->whereIn('store_id', $list_store->pluck('id')->toArray())->get();
        $coupons = $this->entity->whereIn('coupon_type_id', $list_coupon_type->pluck('id')->toArray())->with('coupon_type')->orderBy('updated_at', 'desc')->paginate(REQUEST_COUPON_ITEMS);
        return view('admin::pages.coupon.index',compact('coupons', 'list_store', 'list_coupon_type'));
    }


    public function view_more()
    {
        $page_num = $this->request->page;
        $list_coupon_type = $this->type->whereIn('store_id', $this->request->stores->pluck('id')->toArray())->lists('id')->toArray();
        $coupons = $this->entity->whereIn('coupon_type_id', $list_coupon_type)->with('coupon_type')->skip($page_num*REQUEST_COUPON_ITEMS)->take(REQUEST_COUPON_ITEMS)->orderBy('updated_at', 'desc')->get();
        $returnHTML = view('admin::pages.coupon.element_coupon')->with(compact('coupons'))->render();
        return $returnHTML;
    }

    public function approve($coupon_id, $post_id)
    {
        $app_user = Post::find($post_id)->app_user()->first(); 
        
        $app_user->coupons()->attach($coupon_id);
        Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Approve coupon successfully') );
        return back();
    }

    public function unapprove($coupon_id, $post_id)
    {
        $app_user = Post::find($post_id)->app_user()->first(); 
        
        $app_user->coupons()->detach($coupon_id);
        return redirect()->back();
    }


    public function create()
    {

    }

    public function store_type()
    {
        $rules = [
            'title' => 'required|Max:255',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }

        $data = [
            'name' => $this->request->title,
            'store_id' => $this->request->store_id,
        ];

        try {
            $this->type = $this->type->create($data);
            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Approve coupon type successfully') );
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Approve coupon type fail') );
            return back();
        }
            
    }

    public function store()
    {
        //dd($this->request->hashtag); die();
        if ($this->request->image_create != null && $this->request->image_create->isValid()) {
            $file = array('image_create' => $this->request->image_create);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_create->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_create->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $contentType = mime_content_type($this->request->image_create->getRealPath());

            if(! in_array($contentType, $allowedMimeTypes) ){
              return redirect()->back()->withError('The uploaded file is not an image');
            }
            $this->request->image_create->move($destinationPath, $fileName); // uploading file to given path
            $image_create = $destinationPath . '/' . $fileName;
        } else {
            return redirect()->back()->withError('Please upload a image ');
        }


        try {


            $data = [
                'title' => $this->request->input('title'),
                'description' => $this->request->input('description'),
                'start_date' => $this->request->input('start_date'),
                'end_date' => $this->request->input('end_date'),
                'coupon_type_id' => $this->request->coupon_type_id,
                'status' => 1,
                'image_url' => $image_create,
            ];

            $this->entity = $this->entity->create($data);

            $tag_list = [];
            if ($this->request->hashtag !== null) {
                preg_match_all('/#([^\s]+)/', $this->request->hashtag, $matches);
                $tag_list = $matches[1];
            }   

            foreach ($tag_list as $tagName) {
                $tag = Tag::whereTag($tagName)
                    ->first();
                if ($tag === null) {
                    $tag = new Tag();
                    $tag->tag = $tagName;
                    $tag->save();
                }
                try {
                    $tag->coupons()->attach($this->entity->id);
                } catch (\Illuminate\Database\QueryException $e) {
                }
            }

            $this->dispatch(new InstagramHashtagJob($this->entity->id));

            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Add coupon successfully') );
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Add coupon fail') );
        }

    }

    public function show($id)
    {
        $coupon = $this->entity->find($id);
        $hashtag = Coupon::find($id)->tags()->lists('id')->toArray();
        $hashtag_id = '(' . implode(',', $hashtag) . ')';
        // $posts = DB::select(DB::raw('SELECT posts.*
        //         from rel_posts_tags
        //         INNER JOIN posts on rel_posts_tags.post_id=posts.id
        //         where posts.deleted_at is null AND rel_posts_tags.tag_id IN ' . $hashtag_id . 'ORDER BY posts.created_at DESC LIMIT 20'));
        //$posts = Post::with('tags')->paginate(10);
        $posts = Post::whereHas('tags', function ($q) use ($hashtag) {
            $q->whereIn('id', $hashtag);  
        })->with('tags')->paginate(2); 
        for ($i = 0; $i < count($posts); $i++)
        {

            $app_user = Post::find($posts[$i]->id)->app_user()->first(); 
            $exists = DB::table('rel_app_users_coupons')
            ->whereAppUserId($app_user->id)
            ->whereCouponId($id)
            ->count() > 0;
            if ($exists)
            {
                $posts[$i]->status = 1;
            } else 
            {
                $posts[$i]->status = 0;
            }

        }
        
        
        return view('admin::pages.coupon.show',compact('coupon', 'posts'));
    }

    public function edit(Store $store, $id)
    {
        $all_coupon = $this->entity->all();
        $list_store = $store->lists('name','id');
        $coupon = $this->entity->find($id);

        return view('admin::pages.coupon.edit',compact('coupon','list_store','all_coupon'));
    }

    public function update($id)
    {
       // dd($this->request); die();
        $image_edit = null;
        if ($this->request->image_edit != null && $this->request->image_edit->isValid()) {
            $file = array('image_edit' => $this->request->image_edit);
            $destinationPath = 'uploads'; // upload path
            $extension = $this->request->image_edit->getClientOriginalExtension(); // getting image extension
            $fileName = md5($this->request->image_edit->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $extension; // renameing image
            $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
            $contentType = mime_content_type($this->request->image_edit->getRealPath());

            if(! in_array($contentType, $allowedMimeTypes) ){
              return redirect()->back()->withError('The uploaded file is not an image');
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }

        try {
            $this->entity = $this->entity->find($this->request->input('id'));

            $this->entity->title = $this->request->input('title');
            $this->entity->description = $this->request->input('description');
            $this->entity->start_date = $this->request->input('start_date');
            $this->entity->end_date = $this->request->input('end_date');
            $this->entity->coupon_type_id = $this->request->input('coupon_type_id');

            if ($image_edit)
            {
                $this->entity->image_url = $image_edit;
            }
            
            $this->entity->save();
            $tag_list = [];
            if ($this->request->hashtag !== null) {
                preg_match_all('/#([^\s]+)/', $this->request->hashtag, $matches);
                $tag_list = $matches[1];
            }   

            foreach ($tag_list as $tagName) {
                $tag = Tag::whereTag($tagName)
                    ->first();
                if ($tag === null) {
                    $tag = new Tag();
                    $tag->tag = $tagName;
                    $tag->save();
                }
                try {
                    $tag->coupons()->attach($this->entity->id);
                } catch (\Illuminate\Database\QueryException $e) {
                }
            }

            $this->dispatch(new InstagramHashtagJob($this->entity->id));
            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Edit coupon successfully') );
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Edit coupon fail') );
            return back();
        }

        // $coupon = $this->entity->find($id);
        // $coupon->name = $this->request->input('name');
        // $coupon->store_id = $this->request->input('store_id');
        // $coupon->save();

        return redirect()->route('admin.coupon.index');
    }

    public function destroy($id)
    {
        try {
            $this->entity = $this->entity->find($this->request->input('id'));
            $this->entity->app_users()->detach();
        	$this->entity->destroy($this->request->input('id'));
            Session::flash( 'message', array('class' => 'alert-success', 'detail' => 'Delete coupon successfully') );
            return back();
        } catch (\Illuminate\Database\QueryException $e) {
            Session::flash( 'message', array('class' => 'alert-danger', 'detail' => 'Delete coupon fail') );
            return back();
        }
    }
}

