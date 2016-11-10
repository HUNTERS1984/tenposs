<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/16/16
 * Time: 6:15 AM
 */

namespace App\Utils;


use App\Models\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class RedisControl
{
    public static function delete_cache_redis($cache_delete_type, $store_id = 0,$category_id = 0)
    {
        $app_data = App::where('user_id', Auth::user()->id)->first();
        $prefix_cache = '';
        switch ($cache_delete_type) {
            case 'news':
                $prefix_cache = sprintf(Config::get('api.cache_delete_news'), $app_data->app_app_id, $store_id);
                break;
            case 'top_news':
                $prefix_cache = sprintf(Config::get('api.cache_delete_top_news'), $app_data->app_app_id);
                break;
            case 'app_detail':
                $prefix_cache = sprintf(Config::get('api.cache_delete_app_detail'), $app_data->app_app_id);
                break;
            case 'app_info':
                $prefix_cache = sprintf(Config::get('api.cache_delete_app_info'), $app_data->app_app_id);
                break;
            case 'top_images':
                $prefix_cache = sprintf(Config::get('api.cache_delete_top_images'), $app_data->app_app_id);
                break;
            case 'items':
                $prefix_cache = sprintf(Config::get('api.cache_delete_items'), $app_data->app_app_id);
                break;
            case 'menus':
                $prefix_cache = sprintf(Config::get('api.cache_delete_menus'), $app_data->app_app_id);
                break;
            case 'photo_cat':
                $prefix_cache = sprintf(Config::get('api.cache_delete_photo_cat'), $app_data->app_app_id, $store_id);
                break;
            case 'photos':
                $prefix_cache = sprintf(Config::get('api.cache_delete_photos'), $app_data->app_app_id, $category_id);
                break;
            case 'reserve':
                $prefix_cache = sprintf(Config::get('api.cache_delete_reserve'), $app_data->app_app_id, $store_id);
                break;
            case 'coupons':
                $prefix_cache = sprintf(Config::get('api.cache_delete_coupons'), $app_data->app_app_id);
                break;
            case 'top_photos':
                $prefix_cache = sprintf(Config::get('api.cache_delete_top_photos'), $app_data->app_app_id);
                break;
            case 'top_items':
                $prefix_cache = sprintf(Config::get('api.cache_delete_top_items'), $app_data->app_app_id);
                break;
            case 'top_contacts':
                $prefix_cache = sprintf(Config::get('api.cache_delete_top_contacts'), $app_data->app_app_id);
                break;
            case 'staff_cat':
                $prefix_cache = sprintf(Config::get('api.cache_staff_categories'), $app_data->app_app_id, $store_id);
                break;
            case 'news_cat':
                $prefix_cache = sprintf(Config::get('api.cache_news_cat'), $app_data->app_app_id, $store_id);
                break;
            default:
                break;
        }
        $ls_key = RedisUtil::getInstance()->get_all_key();
        if (count($ls_key) > 0) {
            foreach ($ls_key as $item) {
                $pos = strpos($item, $prefix_cache);
                if ($pos !== false) {
                    RedisUtil::getInstance()->set_cache($item, null);
                }
            }
        }
    }
}