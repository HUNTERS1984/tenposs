<?php
namespace App\Repositories\Eloquents;
use App\News;
use App\Repositories\Contracts;
use Illuminate\Database\QueryException;
use  DB;
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
                $total_data = News::where('store_id', '=', $store_id)->count();
                if ($total_data > 0)
                {
                    $news = News::where('store_id', '=', $store_id)->skip($page)->take($pagesize)->get()->toArray();
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
                $total_data = News::all()->count();
                if ($total_data > 0) {
                    $photos = DB::table('news')->skip($page)->take($pagesize)->get()->toArray();
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
        return $arrResult;
    }

    public function getDetail($new_id)
    {
        // TODO: Implement getDetail() method.
    }
}