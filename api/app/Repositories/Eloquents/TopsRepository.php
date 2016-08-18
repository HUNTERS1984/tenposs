<?php
namespace App\Repositories\Eloquents;

use App\Models\AppSetting;
use App\Models\App;
use App\Models\Address;
use App\Models\News;
use App\Models\UserSession;
use App\Models\Photo;
use App\Models\PhotoCat;
use App\Models\Item;
use App\Models\Menu;
use App\Models\TopMainImage;
use App\Models\User;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use DB;
use Illuminate\Support\Facades\Config;

define("TOP_MAX_ITEM", 8);

class TopsRepository implements TopsRepositoryInterface
{
    public function get_top_items($app_app_id)
    {
        $items = [];
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $menus = Menu::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->lists('id')->toArray();

            $menus_id = '(' . implode(',', $menus) . ')';

            $items = DB::select(DB::raw('SELECT items.id, items.title, items.price, items.image_url, items.coupon_id, items.created_at, items.updated_at, items.deleted_at 
                from rel_menus_items 
                INNER JOIN items on rel_menus_items.item_id=items.id 
                INNER JOIN menus on rel_menus_items.menu_id=menus.id 
                where items.deleted_at is null AND rel_menus_items.menu_id IN ' . $menus_id . 'ORDER BY items.created_at DESC LIMIT ' . TOP_MAX_ITEM));
            for ($i = 0; $i < count($items); $i++) {
                $items[$i]->image_url = url('/') . '/' . $items[$i]->image_url;
            }
        }

        return $items;
    }

    public function get_top_photos($app_app_id)
    {
//        return Photo::all()->take(10);
//        return DB::table('photos')
//            ->join('photo_categories', 'photo_categories.id', '=', 'photos.photo_category_id')
//            ->select('photos.id','photos.image_url','photos.photo_category_id', 'photo_categories.name')
//            ->paginate(6);
        // return DB::select('select p.id,p.image_url,p.photo_category_id,pc.`name` from `photos` p 
        //                     inner join `photo_categories` pc
        //                     on p.photo_category_id = pc.id 
        //                     order by p.id desc
        //                     limit 10
        //                     ');

        $photos = [];
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $photocats_id = PhotoCat::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->lists('id')->toArray();

            $photos = Photo::whereIn('photo_category_id', $photocats_id)->take(TOP_MAX_ITEM)->orderBy('created_at', 'desc')->get()->toArray();
            for ($i = 0; $i < count($photos); $i++) {
                $photos[$i]['image_url'] = url('/') . '/' . $photos[$i]['image_url'];
            }
        }

        return $photos;
    }

    public function get_top_news($app_app_id)
    {
        $news = [];
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $news = News::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->take(TOP_MAX_ITEM)->orderBy('id', 'desc')->get()->toArray();
            for ($i = 0; $i < count($news); $i++) {
                $news[$i]['image_url'] = url('/') . '/' . $news[$i]['image_url'];
            }
        }
        return $news;
    }

    public function get_top_images($app_app_id)
    {
        $images = [];
        $app_setting = $this->get_app_info($app_app_id)->app_setting()->first();
        if ($app_setting) {
            $images = $app_setting->images()->take(TOP_MAX_ITEM)->select('image_url')->orderBy('created_at', 'desc')->get()->toArray();
            for ($i = 0; $i < count($images); $i++) {
                $images[$i]['image_url'] = url('/') . '/' . $images[$i]['image_url'];
            }
        }

        return $images;
    }

    public function get_top_contacts($app_app_id)
    {
        $contacts = [];
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $contacts = Address::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->select('id', 'title', 'latitude', 'longitude', 'tel', 'start_time', 'end_time')->get()->toArray();
        }

        return $contacts;
    }

    public function get_app_info($app_app_id)
    {
        //create key redis
        $key = sprintf(Config::get('api.cache_app_detail'), $app_app_id);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            return $data;
        }
        $arr = App::where('app_app_id', '=', $app_app_id)->first()->toArray();
        if ($arr != null && count($arr) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $arr);
        return $arr;
    }


    public function list_app()
    {
        return App::all(['name', 'app_app_id', 'app_app_secret']);
    }
}