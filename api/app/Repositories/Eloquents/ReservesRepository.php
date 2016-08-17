<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 8/15/16
 * Time: 6:04 AM
 */

namespace App\Repositories\Eloquents;


use App\Repositories\Contracts\ReservesRepositoryInterface;
use App\Models\Reserve;

class ReservesRepository implements ReservesRepositoryInterface
{

    public function getList($store_id)
    {
        $reserve = [];
        try {
            $news = [];
            if ($store_id > 0) {
                $reserve = Reserve::where('store_id', '=', $store_id)->get()->toArray();

            } else {
                $reserve = Reserve::all()->toArray();
            }
        } catch (QueryException $e) {
            throw $e;
        }
        return $reserve;
    }
}