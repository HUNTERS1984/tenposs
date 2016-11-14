<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Utils\HttpRequestUtil;
use App\Utils\RedisControl;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Utils\UrlHelper;

use App\Models\Store;
use App\Models\App;
use App\Models\Coupon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\CouponType;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Session;
use App\Jobs\InstagramHashtagJob;
use DB;
use Validator;

define('REQUEST_COUPON_ITEMS', 10);

class CouponController extends Controller
{
    protected $request;
    protected $entity;
    protected $type;

    public function __construct(Request $request, Coupon $coupon, CouponType $type)
    {
        $this->request = $request;
        $this->entity = $coupon;
        $this->type = $type;
    }

    public function index()
    {  
        $list_store = $this->request->stores;
        $coupons = array();
        $list_coupon_type = array();
        if (count($list_store) > 0) {
            $list_coupon_type = $this->type->whereIn('store_id', $list_store->pluck('id')->toArray())->whereNull('deleted_at')->orderBy('id', 'DESC')->get();
            $coupons = $this->entity->whereIn('coupon_type_id', $list_coupon_type->pluck('id')->toArray())->whereNull('deleted_at')->with('coupon_type')->orderBy('updated_at', 'desc')->paginate(REQUEST_COUPON_ITEMS);
            for ($i = 0; $i < count($coupons); $i++) {
                if ($coupons[$i]->image_url == null)
                    $coupons[$i]->image_url = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $coupons[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $coupons[$i]->image_url);
            }
        }
        return view('admin.pages.coupon.index', compact('coupons', 'list_store', 'list_coupon_type'));
    }


    public function view_more()
    {
        $page_num = $this->request->page;
        $list_coupon_type = $this->type->whereIn('store_id', $this->request->stores->pluck('id')->toArray())->lists('id')->toArray();
        $coupons = $this->entity->whereIn('coupon_type_id', $list_coupon_type)->with('coupon_type')->skip($page_num * REQUEST_COUPON_ITEMS)->take(REQUEST_COUPON_ITEMS)->orderBy('updated_at', 'desc')->get();
        $returnHTML = view('admin.pages.coupon.element_coupon')->with(compact('coupons'))->render();
        return $returnHTML;
    }

    public function accept()
    {
        $search_str = $this->request->input('search_pattern'); 
        if ($search_str)
        {
            $posts = DB::table('posts')
            ->select('posts.*', 'user_profiles.name AS username', 'user_profiles.avatar_url AS avatar')
            ->join('rel_posts_tags', 'posts.id', '=', 'rel_posts_tags.post_id')
            ->join('tags', 'tags.id', '=', 'rel_posts_tags.tag_id')
            ->join('app_users', 'app_users.id', '=', 'posts.app_user_id')
            ->join('user_profiles', 'app_users.id', '=', 'user_profiles.app_user_id')
            ->where('posts.deleted_at', '=', null)
            ->where(function ($query) use ($search_str) {
                return $query->where('tags.tag', 'LIKE', '%'.$search_str.'%')->orWhere('user_profiles.name', 'LIKE', '%'.$search_str.'%');
            })
            ->groupBy('posts.id')
            ->orderBy('id', 'DESC')
            ->paginate(REQUEST_COUPON_ITEMS, ['*'], 'all_coupon');

            for ($i = 0; $i < count($posts); $i++) {
                $posts[$i]->tags = Post::find($posts[$i]->id)->tags()->get();
                if ($posts[$i]->avatar == null)
                    $posts[$i]->avatar = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $posts[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $posts[$i]->avatar);
            }

            $notapproved_posts = DB::table('posts')
            ->select('posts.*', 'user_profiles.name AS username', 'user_profiles.avatar_url AS avatar')
            ->join('rel_posts_tags', 'posts.id', '=', 'rel_posts_tags.post_id')
            ->join('tags', 'tags.id', '=', 'rel_posts_tags.tag_id')
            ->join('app_users', 'app_users.id', '=', 'posts.app_user_id')
            ->join('user_profiles', 'app_users.id', '=', 'user_profiles.app_user_id')
            ->where('posts.deleted_at', '=', null)
            ->where('posts.status', '=', false)
            ->where(function ($query) use ($search_str) {
                return $query->where('tags.tag', 'LIKE', '%'.$search_str.'%')->orWhere('user_profiles.name', 'LIKE', '%'.$search_str.'%');
            })
            ->groupBy('posts.id')
            ->orderBy('id', 'DESC')
            ->paginate(REQUEST_COUPON_ITEMS, ['*'], 'no_coupon');

            for ($i = 0; $i < count($notapproved_posts); $i++) {
                $notapproved_posts[$i]->tags = Post::find($notapproved_posts[$i]->id)->tags()->get();
                if ($notapproved_posts[$i]->avatar == null)
                    $notapproved_posts[$i]->avatar = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $notapproved_posts[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $notapproved_posts[$i]->avatar);
            }

            $approved_posts = DB::table('posts')
            ->select('posts.*', 'user_profiles.name AS username', 'user_profiles.avatar_url AS avatar')
            ->join('rel_posts_tags', 'posts.id', '=', 'rel_posts_tags.post_id')
            ->join('tags', 'tags.id', '=', 'rel_posts_tags.tag_id')
            ->join('app_users', 'app_users.id', '=', 'posts.app_user_id')
            ->join('user_profiles', 'app_users.id', '=', 'user_profiles.app_user_id')
            ->where('posts.deleted_at', '=', null)
            ->where('posts.status', '=', true)
            ->where(function ($query) use ($search_str) {
                return $query->where('tags.tag', 'LIKE', '%'.$search_str.'%')->orWhere('user_profiles.name', 'LIKE', '%'.$search_str.'%');
            })
            ->groupBy('posts.id')
            ->orderBy('id', 'DESC')
            ->paginate(REQUEST_COUPON_ITEMS, ['*'], 'yes_coupon');

            for ($i = 0; $i < count($approved_posts); $i++) {
                $approved_posts[$i]->tags = Post::find($approved_posts[$i]->id)->tags()->get();
                if ($approved_posts[$i]->avatar == null)
                    $approved_posts[$i]->avatar = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $approved_posts[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $approved_posts[$i]->avatar);
            }
            
            $posts->appends($this->request->only('pattern'))->links();
            $notapproved_posts->appends($this->request->only('pattern'))->links();
            $approved_posts->appends($this->request->only('pattern'))->links();
        } else {
            $posts = Post::whereNull('deleted_at')->orderBy('id', 'DESC')->with('tags')->paginate(REQUEST_COUPON_ITEMS, ['*'], 'all_coupon');
            for ($i = 0; $i < count($posts); $i++) {
                $app_user = Post::find($posts[$i]->id)->app_user()->first();
                $posts[$i]->username = $app_user->profile()->first()->name;
                $posts[$i]->avatar = $app_user->profile()->first()->avatar_url;

                if ($posts[$i]->avatar == null)
                    $posts[$i]->avatar = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $posts[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $posts[$i]->avatar);

            }

            $notapproved_posts = Post::whereNull('deleted_at')->whereStatus(false)->orderBy('id', 'DESC')->with('tags')->paginate(REQUEST_COUPON_ITEMS, ['*'], 'no_coupon');
            
            for ($i = 0; $i < count($notapproved_posts); $i++) {
                $app_user = Post::find($notapproved_posts[$i]->id)->app_user()->first();
                $notapproved_posts[$i]->username = $app_user->profile()->first()->name;
                $notapproved_posts[$i]->avatar = $app_user->profile()->first()->avatar_url;

                if ($notapproved_posts[$i]->avatar == null)
                    $notapproved_posts[$i]->avatar = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $notapproved_posts[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $notapproved_posts[$i]->avatar);
            }

            $approved_posts = Post::whereNull('deleted_at')->whereStatus(true)->orderBy('id', 'DESC')->with('tags')->paginate(REQUEST_COUPON_ITEMS, ['*'], 'yes_coupon');
            
            for ($i = 0; $i < count($approved_posts); $i++) {
                $app_user = Post::find($approved_posts[$i]->id)->app_user()->first();
                $approved_posts[$i]->username = $app_user->profile()->first()->name;
                $approved_posts[$i]->avatar = $app_user->profile()->first()->avatar_url;

                if ($approved_posts[$i]->avatar == null)
                    $approved_posts[$i]->avatar = env('ASSETS_BACKEND') . '/images/wall.jpg';
                else
                    $approved_posts[$i]->avatar = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $approved_posts[$i]->avatar);
            }
        }
       

        return view('admin.pages.coupon.accept', compact('coupon', 'posts', 'notapproved_posts', 'approved_posts'));
    }

    public function approve_post($post_id, $return = true)
    {
        $post = Post::find($post_id);
        $app_user = $post->app_user()->first();

        if (!$app_user)
            return;

        $coupons = DB::table('coupons')
        ->select('coupons.id')
        ->join('rel_coupons_tags', 'coupons.id', '=', 'rel_coupons_tags.coupon_id')
        ->join('rel_posts_tags', 'rel_posts_tags.tag_id', '=', 'rel_coupons_tags.tag_id')
        ->join('posts', 'posts.id', '=', 'rel_posts_tags.post_id')
        ->where('posts.id', '=', $post_id)
        ->where('coupons.end_date', '>=', date('Y-m-d H:i:s'))
        ->where('coupons.start_date', '<=', date('Y-m-d H:i:s'))
        ->get();

//           dd($coupons);
        foreach ($coupons as $coupon) {
            $coupon_id = $coupon->id;
            try {
                $app_user->coupons()->attach($coupon_id);
                //create code for QR
                $data_info = \Illuminate\Support\Facades\DB::table('rel_app_users_coupons')
                    ->where([['app_user_id', '=', $app_user->id], ['coupon_id', '=', $coupon_id]])->get();
                if (count($data_info) > 0) {
                    if (empty($data_info[0]->code)) {
                        \Illuminate\Support\Facades\DB::table('users')
                            ->where([['app_user_id', '=', $app_user->id], ['coupon_id', '=', $coupon_id]])
                            ->update(['code' => md5($coupon_id . date('Y-m-d H:i:s'))]);
                    }
                }
                //push notify to all user on app
        //        $app_data = App::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->first();
                if (count($app_user) > 0) {
                    $data_push = array(
                        'app_user_id' => $app_user->id,
                        'type' => 'coupon',
                        'data_id' => $coupon_id,
                        'data_title' => '',
                        'data_value' => '',
                        'created_by' => \Illuminate\Support\Facades\Auth::user()->email
                    );
                    $push = HttpRequestUtil::getInstance()->post_data_return_boolean(Config::get('api.url_api_notification_app_user_id'), $data_push);
                    if (!$push)
                        Log::info('push fail: ' . json_decode($data_push));
                    //end push
                }
            } catch (\Illuminate\Database\QueryException $e) {

            }
        }
        
        $post->status = true;
        $post->save(); 

        if ($return)  
            return redirect()->back()->with('status','Approve the coupon successfully');
    }
    public function approve()
    {
        $list_store = $this->request->stores;
        $approve_list = $this->request->data;
       
        foreach ($approve_list as $post_id) {
            $this->approve_post($post_id, false);
        }
        return json_encode(array('status' => 'success'));    
    }

    public function approve_all()
    {
        $list_store = $this->request->stores;
        $approve_list = Post::whereNull('deleted_at')->orderBy('id', 'DESC')->pluck('id');
        foreach ($approve_list as $post_id) {
            $this->approve_post($post_id, false);
        }
        return redirect()->back()->with('status','Approve all coupon successfully');  
    }

    public function approve_bk($coupon_id, $post_id)
    {
        $app_user = Post::find($post_id)->app_user()->first();

        $app_user->coupons()->attach($coupon_id);
        //create code for QR
        $data_info = \Illuminate\Support\Facades\DB::table('rel_app_users_coupons')
            ->where([['app_user_id', '=', $app_user->id], ['coupon_id', '=', $coupon_id]])->get();
        if (count($data_info) > 0) {
            if (empty($data_info[0]->code)) {
                \Illuminate\Support\Facades\DB::table('users')
                    ->where([['app_user_id', '=', $app_user->id], ['coupon_id', '=', $coupon_id]])
                    ->update(['code' => md5($coupon_id . date('Y-m-d H:i:s'))]);
            }
        }
        //push notify to all user on app
//        $app_data = App::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->first();
        if (count($app_user) > 0) {
            $data_push = array(
                'app_user_id' => $app_user->id,
                'type' => 'coupon',
                'data_id' => $coupon_id,
                'data_title' => '',
                'data_value' => '',
                'created_by' => \Illuminate\Support\Facades\Auth::user()->email
            );
            $push = HttpRequestUtil::getInstance()->post_data_return_boolean(Config::get('api.url_api_notification_app_user_id'), $data_push);
            if (!$push)
                Log::info('push fail: ' . json_decode($data_push));
            //end push
        }

        return redirect()->back()->with('status','Approve the coupon successfully');
    }

    public function unapprove($coupon_id, $post_id)
    {
        $app_user = Post::find($post_id)->app_user()->first();

        $app_user->coupons()->detach($coupon_id);
        return redirect()->back();
    }

    public function unapprove_post($post_id)
    {
        $post = Post::find($post_id);
        $app_user = $post->app_user()->first();

        $coupons = DB::table('coupons')
        ->select('coupons.id')
        ->join('rel_coupons_tags', 'coupons.id', '=', 'rel_coupons_tags.coupon_id')
        ->join('rel_posts_tags', 'rel_posts_tags.tag_id', '=', 'rel_coupons_tags.tag_id')
        ->join('posts', 'posts.id', '=', 'rel_posts_tags.post_id')
        ->where('posts.id', '=', $post_id)
        ->where('coupons.end_date', '>=', date('Y-m-d H:i:s'))
        ->where('coupons.start_date', '<=', date('Y-m-d H:i:s'))
        ->get();

//           dd($coupons);
        foreach ($coupons as $coupon) {
            $coupon_id = $coupon->id;
            try {
                $app_user->coupons()->detach($coupon_id);
                
            } catch (\Illuminate\Database\QueryException $e) {

            }
        }
        
        $post->status = false;
        $post->save();
        return redirect()->back()->with('status','Unapprove the coupon successfully');
    }


    public function create()
    {

    }


    public function store_type(){
        $rules = [
            'name' => 'required|unique:coupon_types|Max:255',
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
            $this->type->create($data);
            return redirect()->route('admin.coupon.index')->with('status','Create the category successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot create the category');
        }
    }


    public function store(Request $request)
    {
        if ($this->request->image_create != null && $this->request->image_create->isValid()) {
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
            return redirect()->back()->withInput()->withErrors('Please upload a image ');
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
            //delete cache redis
            RedisControl::delete_cache_redis('coupons');

            //push notify to all user on app
            $app_data = App::where('user_id', $request->user['sub'])->first();
            $data_push = array(
                'app_id' => $app_data->id,
                'type' => 'coupon',
                'data_id' => $this->entity->id,
                'data_title' => '',
                'data_value' => '',
                'created_by' => Session::get('user')->email
            );
        
            $push = HttpRequestUtil::getInstance()->post_data_return_boolean(Config::get('api.url_api_notification_app_id'), $data_push);
            if (!$push)
                Log::info('push fail: ' . json_decode($push));
            //end push

            return redirect()->route('admin.coupon.index')->with('status','Create the coupon successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot create the coupon');
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
        //$posts = Post::with('tags')->paginate(REQUEST_COUPON_ITEMS);
        $posts = Post::whereHas('tags', function ($q) use ($hashtag) {
            $q->whereIn('id', $hashtag);
        })->with('tags')->paginate(20);
        for ($i = 0; $i < count($posts); $i++) {

            $app_user = Post::find($posts[$i]->id)->app_user()->first();
            $exists = DB::table('rel_app_users_coupons')
                    ->whereAppUserId($app_user->id)
                    ->whereCouponId($id)
                    ->count() > 0;
            if ($exists) {
                $posts[$i]->status = 1;
            } else {
                $posts[$i]->status = 0;
            }

        }


        return view('admin.pages.coupon.show', compact('coupon', 'posts'));
    }

    public function edit($id)
    {
        $list_store = $this->request->stores;
        $all_coupon = $this->entity->all();

        $list_coupon_type = array();
        if (count($list_store) > 0) {
            $list_coupon_type = $this->type->whereIn('store_id', $list_store->pluck('id')->toArray())->whereNull('deleted_at')->orderBy('id', 'DESC')->get();
        }
        $coupon = $this->entity->whereId($id)->with('tags')->first();
        $coupon->image_url = UrlHelper::convertRelativeToAbsoluteURL(url('/'), $coupon->image_url);
        return view('admin.pages.coupon.edit', compact('coupon', 'list_store', 'all_coupon', 'list_coupon_type'));
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
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
            $contentType = mime_content_type($this->request->image_edit->getRealPath());

            if (!in_array($contentType, $allowedMimeTypes)) {
                return redirect()->back()->withInput()->withErrors('The uploaded file is not an image');
            }
            $this->request->image_edit->move($destinationPath, $fileName); // uploading file to given path
            $image_edit = $destinationPath . '/' . $fileName;
        }

        try {
            $this->entity = $this->entity->find($id);
            $this->entity->title = $this->request->input('title');
            $this->entity->description = $this->request->input('description');
            $this->entity->start_date = $this->request->input('start_date');
            $this->entity->end_date = $this->request->input('end_date');
            $this->entity->coupon_type_id = $this->request->input('coupon_type_id');

            if ($image_edit) {
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
            //delete cache redis
            RedisControl::delete_cache_redis('coupons');
            return redirect()->route('admin.coupon.index')->with('status','Edit the coupon successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot edit the coupon');
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
            $this->entity = $this->entity->find($id);
            if ($this->entity) {
                $this->entity->app_users()->detach();
                $this->entity->destroy($id);
                return redirect()->route('admin.coupon.index')->with('status','Delete the coupon successfully');
            } else {
                return redirect()->back()->withErrors('Cannot delete the coupon');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors('Cannot delete the coupon');
        }
    }

    public function coupon_use_code_view($user_id, $coupon_id, $code, $sig)
    {
        $code_hash = hash('sha256', $user_id . $coupon_id . $code . '-' . Config::get('api.secret_key_coupon_use'));
        $is_approve = true;

        if ($code_hash != $sig) {
            $is_approve = false;
            return view('admin.pages.coupon.code_use', compact('user_id', 'coupon_id', 'code', 'sig', 'is_approve'));
        }
        try {
            $coupon_code = \Illuminate\Support\Facades\DB::table('rel_app_users_coupons')
                ->whereAppUserId($user_id)
                ->whereCouponId($coupon_id)->get();

            if (count($coupon_code) > 0) {
                if ($coupon_code[0]->code != $code) {
                    $is_approve = false;
                    return view('admin.pages.coupon.code_use', compact('user_id', 'coupon_id', 'code', 'sig', 'is_approve'));
                }
            } else {
                $is_approve = false;
                return view('admin.pages.coupon.code_use', compact('user_id', 'coupon_id', 'code', 'sig', 'is_approve'));
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $is_approve = false;
            return view('admin.pages.coupon.code_use', compact('user_id', 'coupon_id', 'code', 'sig', 'is_approve'));
        }

        return view('admin.pages.coupon.code_use', compact('user_id', 'coupon_id', 'code', 'sig', 'is_approve'));
    }

    public function coupon_use_code_approve()
    {
        $user_id = $this->request->user_id;
        $coupon_id = $this->request->coupon_id;
        $code = $this->request->code;
        $sig = $this->request->sig;
        $code_hash = hash('sha256', $user_id . $coupon_id . $code . '-' . Config::get('api.secret_key_coupon_use'));

        $is_approve_success = true;
        if ($code_hash != $sig) {
            $is_approve_success = false;
            return view('admin.pages.coupon.code_use_approve', compact('is_approve_success'));
        }
        try {
            $coupon_code = \Illuminate\Support\Facades\DB::table('rel_app_users_coupons')
                ->whereAppUserId($user_id)
                ->whereCouponId($coupon_id)->get();
            if (count($coupon_code) > 0) {
                if ($coupon_code[0]->code != $code) {
                    $is_approve_success = false;
                    return view('admin.pages.coupon.code_use_approve', compact('is_approve_success'));
                }
            } else {
                $is_approve_success = false;
                return view('admin.pages.coupon.code_use_approve', compact('is_approve_success'));
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $is_approve_success = false;
            return view('admin.pages.coupon.code_use_approve', compact('is_approve_success'));
        }
        try {
            \Illuminate\Support\Facades\DB::table('rel_app_users_coupons')
                ->whereAppUserId($user_id)
                ->whereCouponId($coupon_id)->update(['code' => '']);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            $is_approve_success = false;
            return view('admin.pages.coupon.code_use_approve', compact('is_approve_success'));
        }
        return view('admin.pages.coupon.code_use_approve', compact('is_approve_success'));
    }
}

