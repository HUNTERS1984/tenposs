<?php
namespace App\Repositories\Eloquents;

use App\Models\News;
use App\Repositories\Contracts;
use Illuminate\Database\QueryException;
use  DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Config;

class NewsRepository implements Contracts\NewsRepositoryInterface
{

    public function getList($store_id, $pageindex, $pagesize)
    {
        $arrResult= [];
        try
        {
            $page = ($pageindex - 1) * $pagesize;
            $news= [];
            if ($store_id > 0)
            {
                $total_data = News::where('store_id', '=', $store_id)->whereNull('deleted_at')->count();
                if ($total_data > 0)
                {
                    $news = News::where('store_id', '=', $store_id)->whereNull('deleted_at')->skip($page)->take($pagesize)->get()->toArray();
                    $arrResult['news']  = $news;
                    $arrResult['total_news'] = $total_data;
                }
                else
                {
                    $arrResult['news']  = $news;
                    $arrResult['total_news'] = 0;
                }
            }
            else
            {
                $key = "user_1";


                $total_data = News::all()->count();
                if ($total_data > 0) {
                        $photos =   Redis::get($key);
                        if ($photos != null) {
                            $photos = DB::table('news')->skip($page)->take($pagesize)->get();
                            Redis::set($key,serialize(array(5, 10)));
                        }

                    $arrResult['news']  = $photos;
                    $arrResult['total_news'] = $total_data;
                }
                else
                {
                    $arrResult['news']  = $news;
                    $arrResult['total_news'] = 0;
                }
            }
        }catch (QueryException $e)
        {
            throw $e;
        }
        $key = Config::get('api.cache_news').'_$store_id_$pagesize_$pagesize';
        $redis = Redis::connection();
        $redis->set($key,json_encode($arrResult));
        return $arrResult;
    }

    public function getDetail($new_id)
    {
        // TODO: Implement getDetail() method.
    }
}