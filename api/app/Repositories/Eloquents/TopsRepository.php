<?php
namespace App\Repositories\Eloquents;

use App\Models\AppSetting;
use App\Models\App;
use App\Models\Address;
use App\Models\News;
use App\Models\NewCat;
use App\Models\ShareCodeInfo;
use App\Models\UserSession;
use App\Models\Photo;
use App\Models\PhotoCat;
use App\Models\Item;
use App\Models\Menu;
use App\Models\TopMainImage;
use App\Models\User;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\RedisUtil;
use App\Utils\UrlHelper;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

define("TOP_MAX_ITEM", 4);
define("TOP_MAX_PHOTO", 9);

class TopsRepository implements TopsRepositoryInterface
{
    public function get_top_items($app_app_id)
    {
        //create key redis
        $key = sprintf(Config::get('api.cache_top_items'), $app_app_id);
        //get data from redis
        $items = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($items != null) {
            return $items;
        }
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $menus = Menu::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->lists('id')->toArray();

            $menus_id = '(' . implode(',', $menus) . ')';

            $items = DB::select(DB::raw('SELECT items.id, items.title, items.price, items.image_url, items.created_at, items.updated_at, items.deleted_at, menus.name AS menu 
                from rel_menus_items 
                INNER JOIN items on rel_menus_items.item_id=items.id 
                INNER JOIN menus on rel_menus_items.menu_id=menus.id 
                where items.deleted_at is null AND rel_menus_items.menu_id IN ' . $menus_id . 'ORDER BY items.created_at DESC LIMIT ' . TOP_MAX_ITEM));
            for ($i = 0; $i < count($items); $i++) {
                $items[$i]->image_url = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $items[$i]->image_url);
            }
        }
        if ($items != null && count($items) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $items);
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

        //create key redis
        $key = sprintf(Config::get('api.cache_top_photos'), $app_app_id);
        //get data from redis
        $photos = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($photos != null) {
            return $photos;
        }
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $photocats_id = PhotoCat::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->lists('id')->toArray();

            $photos = Photo::whereIn('photo_category_id', $photocats_id)->take(TOP_MAX_PHOTO)->orderBy('created_at', 'desc')->get()->toArray();
            for ($i = 0; $i < count($photos); $i++) {
                $photos[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $photos[$i]['image_url']);
            }
        }
        if ($photos != null && count($photos) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $photos);
        return $photos;
    }

    public function get_top_news($app_app_id)
    {
        //create key redis
        $key = sprintf(Config::get('api.cache_top_news'), $app_app_id);
        //get data from redis
        $news = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($news != null) {
            return $news;
        }
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $news_cat = NewCat::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->lists('id')->toArray();
            $news = News::whereIn('new_category_id', $news_cat)->take(TOP_MAX_ITEM)->orderBy('created_at', 'desc')->get()->toArray();
            for ($i = 0; $i < count($news); $i++) {
                $news[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $news[$i]['image_url']);
            }
        }
        if ($news != null && count($news) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $news);
        return $news;
    }

    public function get_top_images($app_app_id)
    {
        //create key redis
        $key = sprintf(Config::get('api.cache_top_images'), $app_app_id);
//        //get data from redis
        $images = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($images != null) {
            return $images;
        }
        $app_setting = $this->get_app_info($app_app_id)->app_setting()->first();
//        print_r($app_setting->images()->select('image_url')->get());die;
        if ($app_setting) {
            $images = $app_setting->images()->take(TOP_MAX_ITEM)->select('image_url')->orderBy('created_at', 'desc')->get()->toArray();
            for ($i = 0; $i < count($images); $i++) {
                $images[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $images[$i]['image_url']);
            }
        }

        if ($images != null && count($images) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $images);
        return $images;
    }

    public function get_top_contacts($app_app_id)
    {
        //create key redis
        $key = sprintf(Config::get('api.cache_top_contacts'), $app_app_id);
        //get data from redis
        $contacts = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($contacts != null) {
            return $contacts;
        }
        $app = $this->get_app_info($app_app_id);
        if ($app) {
            $stores = $app->stores()->lists('id')->toArray();

            $contacts = Address::whereHas('store', function ($query) use ($stores) {
                $query->whereIn('store_id', $stores);
            })->select('id', 'title', 'latitude', 'longitude', 'tel', 'start_time', 'end_time')->get()->toArray();
        }
        if ($contacts != null && count($contacts) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $contacts);
        return $contacts;
    }

    public function get_app_info($app_app_id)
    {
        try {
            return App::where('app_app_id', '=', $app_app_id)->first();
        } catch (QueryException $e) {
            throw $e;
        }
        return null;
    }

    public function list_app()
    {
        return App::all(['name', 'app_app_id', 'app_app_secret']);
    }

    public function get_app_info_array($app_app_id)
    {
        //create key redis
        $key = sprintf(Config::get('api.cache_app_detail'), $app_app_id);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($data != null) {
            return $data;
        }
        $arr = App::where('app_app_id', '=', $app_app_id)->first();
        if ($arr != null && count($arr) > 0)//set cache redis
        {
            RedisUtil::getInstance()->set_cache($key, $arr);
            return $arr;
        }

        return null;
    }

    public function get_app_info_from_token($token)
    {
        if (!$token || $token == '')
            return null;
        //create key redis
        $key = sprintf(Config::get('api.cache_app_detail_token'), $token);
        //get data from redis
        $app_info = RedisUtil::getInstance()->get_cache($key);
        //check data and return data
        if ($app_info != null) {
            return $app_info;
        }
//        print_r($app_info);
        $session = UserSession::where('token', $token)->first();
        if ($session) {
            $user = $session->app_user()->first()->toArray();
            if ($user) {
                $app_info = App::where('id', '=', $user['app_id'])->first()->toArray();
            }
        }
//        print_r($app_info);die;
        if ($app_info != null && count($app_info) > 0)//set cache redis
            RedisUtil::getInstance()->set_cache($key, $app_info);
        return $app_info;
    }


    public function check_share_code($app_id, $code, $source, $app_uuid, $email)
    {
        $error_code = 1000;
        try {
            $sharecode = ShareCodeInfo::where('code', $code)
                ->where('app_id', $app_id)->first();
          
            if (count($sharecode) < 1)
                $error_code = 1015;
            else {
                if ($sharecode->status == 1)
                    $error_code = 1016;
                else {
                    //code available
                    if ($source == 'web') {
                        $sharecode_source = ShareCodeInfo::where('email', $email)
                            ->where('app_id', $app_id)->first();
                        if (count($sharecode_source) > 0)
                            $error_code = 1017;
                    } else {
                        $sharecode_source = ShareCodeInfo::where('app_uuid', $app_uuid)
                            ->where('app_id', $app_id)->first();
                        if (count($sharecode_source) > 0)
                            $error_code = 1018;
                    }
                }
            }
        } catch (\Doctrine\DBAL\Query\QueryException $e) {
            Log::error($e->getMessage());
        }
        return $error_code;
    }
}