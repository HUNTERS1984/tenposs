<?php

/**
 *
 * ArraySearch
 *
 * Created for do to search inside of array.
 * if you do $all is 1, all results will return to array
 *
 * Example: ArraySearch( array $dizi, string "key1 = 'bunaesitolmali1' and key2 >= 'bundanbuyukolmali' or key3 != 'bunaesitolmasin3'", int $all = 0 );
 *
 */

namespace App\Helpers;

class ArrayHelper
{

    public static function  ArraySearch($SearchArray, $query, $all = 0, $Return = 'direct')
    {

        function search($array, $key, $value)
        {
            $results = array();
        
            if (is_array($array)) {
                if (isset($array[$key]) && $array[$key] == $value) {
                    $results[] = $array;
                }
        
                foreach ($array as $subarray) {
                    $results = array_merge($results, search($subarray, $key, $value));
                }
            }
        
            return $results;
        }


    }
}