<?php
namespace App\Repositories\Redis;
use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;

class RedisNewsRepository implements NewsRepositoryInterface
{

    public function getList($store_id, $pageindex, $pagesize)
    {
        try
        {
            $redis = Redis::connection();
            $key = Config::get('api.cache_news').'_$store_id_$pagesize_$pagesize';
            return $redis->get($key);
        }
        catch (RedisException $e)
        {
            throw $e;
        }
    }

    public function getDetail($new_id)
    {
        // TODO: Implement getDetail() method.
    }
}