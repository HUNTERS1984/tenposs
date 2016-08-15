<?php
namespace App\Repositories\Eloquents;

use App\Photo;
use App\Repositories\Contracts\PhotosRepositoryInterface;
use Illuminate\Database\QueryException;

class PhotosRepository implements PhotosRepositoryInterface
{
    public function getList($category_id, $pageindex, $pagesize)
    {
        $arrResult= [];
        try {
            $photos = [];
            $page = ($pageindex - 1) * $pagesize;
            if ($category_id > 0) {
                $total_data = Photo::where('photo_category_id', '=', $category_id)->count();

                if ($total_data > 0) {
                    $photos = Photo::where('photo_category_id', '=', $category_id)->skip($page)->take($pagesize)->get()->toArray();
                    $arrResult['photos']  = $photos;
                    $arrResult['total_photos'] = $total_data;
                }

            } else {
                $total_data = Photo::all()->count();
                if ($total_data > 0) {
                    $photos = DB::table('photos')->skip($page)->take($pagesize)->get()->toArray();
                    $arrResult['photos']  = $photos;
                    $arrResult['total_photos'] = $total_data;
                }

            }

        } catch (QueryException $e) {
            throw $e;
        }
        return $arrResult;
    }
}