<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\UserSession;
use App\Models\AppUser;
use App\Models\App;
use App\Models\AppSetting;
use App\Models\Store;
use App\Models\Menu;
use App\Models\News;
use App\Models\Item;
use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\Reserve;
use App\Models\UserProfile;
use App\Models\UserPush;
use Mail;
use App\Address;
use Illuminate\Support\Facades\Hash;
use DB;
use Twitter;

class TopController extends Controller
{

    protected $request;
    protected $_topRepository;

//    public function __construct(Request $request)
//    {
//        $this->request = $request;
//    }
    public function __construct(TopsRepositoryInterface $ur,Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }


    public function top(Request $request) {

        $check_items = array('app_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $app = App::find(Input::get('app_id'));
        if (!$app)
            return $this->error(1004); 

        $stores = $app->stores()->with('menus', 'photo_cats', 'news', 'addresses')->get()->toArray();

        $images = $app->app_top_main_images()->get()->toArray();

        for ($i = 0; $i < count($images); $i++)
        {
            $images[$i]['image_url'] = url('/').$images[$i]['image_url'];
        }

        $menus = array_pluck($stores, 'menus');
        $photocats = array_pluck($stores, 'photo_cats');
        $news_all = array_pluck($stores, 'news');
        $addresses = array_pluck($stores, 'addresses');
        
        $menus_id = [];
        foreach ($menus as $key => $value) {
            $menus_id = array_collapse([$menus_id, array_pluck($value, 'id')]);
        }        
        $menus_id = '('.implode(',', $menus_id).')';

        $items = DB::select(DB::raw('SELECT items.id, items.title, items.price, items.image_url, items.coupon_id, items.created_at, items.updated_at, items.deleted_at from rel_menus_items INNER JOIN items on rel_menus_items.item_id=items.id INNER JOIN menus on rel_menus_items.menu_id=menus.id where items.deleted_at is null AND rel_menus_items.menu_id IN '.$menus_id.'ORDER BY items.created_at DESC LIMIT 8'))->toArray();

        for ($i = 0; $i < count($items); $i++) {
            $items[$i]['id'] = intval($items[$i]['id']);
            $items[$i]['image_url'] = url('/').$items[$i]['image_url'];
        }
        $photocats_id = [];
        foreach ($photocats as $key => $value) {
            $photocats_id = array_collapse([$photocats_id, array_pluck($value, 'id')]);
        }       

        $photos = Photo::whereIn('photo_category_id',$photocats_id)->get();

        $news = [];
        foreach ($news_all as $key => $value) {

            $news = array_collapse([$news,$value]);
        }        
        $photos = Photo::whereIn('photo_category_id',$photocats_id)->get();

        $this->body['data']['images']['top_id'] = 1;
        $this->body['data']['images']['data'] = $images;
        $this->body['data']['items']['top_id'] = 2;
        $this->body['data']['items']['data'] = $items;
        $this->body['data']['photos']['top_id'] = 3;
        $this->body['data']['photos']['data'] = $photos;
        $this->body['data']['news']['top_id'] = 4;
        $this->body['data']['news']['data'] = $news;
        $this->body['data']['contact']['top_id'] = 5;
        $this->body['data']['contact']['data'] = $addresses;
        

        return $this->output($this->body);
    }

    public function appinfo(Request $request) {
        
        $check_items = array('app_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;


        try {
            $app = App::find(Input::get('app_id'));
            if ($app)
                $app_data = $app->with('app_setting','top_components','side_menu', 'stores')->first()->toArray();
            else
                return $this->error(1004);

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data'] = $app_data;
        return $this->output($this->body);
    }

}
