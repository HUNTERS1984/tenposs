<?php
namespace App\Repositories\Eloquents;

use App\Models\Item;
use App\Models\Menu;
use App\Repositories\Contracts\ItemsRepositoryInterface;
use DB;

class ItemsRepository implements ItemsRepositoryInterface
{

    public function getList($menu_id, $pageindex, $pagesize)
    {
        $arrResult = array();
        return $arrResult;
        try {
            $items = [];
            $page = ($pageindex - 1) * $pagesize;
            if ($menu_id > 0) {
                $total_data = Menu::find($menu_id)->items()->count();
                if ($total_data > 0) {
                    $items = Menu::find($menu_id)->items()->skip($page)->take($pagesize)->with('rel_items')->get()->toArray();
                    $arrResult['items'] = $items;
                    $arrResult['total_items'] = $total_data;
                } else {
                    $arrResult['items'] = $items;
                    $arrResult['total_items'] = 0;
                }


            } else {
                $total_data = $total_data = Menu::all()->count();
                if ($total_data > 0) {
                    $items = DB::table('items')
                        ->leftJoin('rel_items', 'items.id', '=', 'rel_items.item_id')
                        ->skip($page)->take($pagesize)->get()->toArray();
                    $arrResult['items'] = $items;
                    $arrResult['total_items'] = $total_data;
                } else {
                    $arrResult['items'] = $items;
                    $arrResult['total_items'] = 0;
                }
            }

        } catch (QueryException $e) {
            throw $e;
        }
        return $arrResult;
    }

    public function getDetail($item_id)
    {
        // TODO: Implement getDetail() method.
    }
}