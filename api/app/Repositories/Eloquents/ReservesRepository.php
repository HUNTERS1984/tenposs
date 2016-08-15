<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 8/15/16
 * Time: 6:04 AM
 */

namespace App\Repositories\Eloquents;


use App\Repositories\Contracts\ReservesRepositoryInterface;
use App\Reserve;

class ReservesRepository implements ReservesRepositoryInterface
{

    public function getList($store_id)
    {
        $arrResult = [];
        try {
            $news = [];
            if ($store_id > 0) {
                $news = Reserve::where('store_id', '=', $store_id)->get()->toArray();
                $arrResult['reserve'] = $news;

            } else {
                $photos = Reserve::all()->toArray();
                $arrResult['reserve'] = $photos;
            }
        } catch (QueryException $e) {
            throw $e;
        }
        return $arrResult;
    }
}