<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/6/16
 * Time: 6:51 AM
 */

namespace App\Utils;


class Convert
{
    public static function convert_size_item_to_array($sizes)
    {
        $new_array = array(); 
        foreach ($sizes as $item) {
            $new_array[$item->item_size_type_id][] = $item;
        }
        return $new_array;
    }
}