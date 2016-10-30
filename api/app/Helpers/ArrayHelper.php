<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function searchArray($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, self::search($subarray, $key, $value));
            }
        }

        return $results;
    }

    public static function searchObject($array, $value){
        foreach( $array as $object ){
            if( $object->id == (int)$value )
                return $object;
        }
        return false;
    }


}