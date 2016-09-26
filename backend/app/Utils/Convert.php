<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/26/16
 * Time: 4:36 AM
 */

namespace App\Utils;


class Convert
{
    public static function get_value_size_from_type_category_id($arr, $type_id, $category_id)
    {
        $value = 0;
        foreach ($arr as $item) {
            if ($item->item_size_type_id == $type_id && $item->item_size_category_id == $category_id) {
                $value = $item->value;
                break;
            }
        }
        return $value;
    }

}