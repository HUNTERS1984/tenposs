<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/29/16
 * Time: 4:34 AM
 */

namespace App\Utils;


class ValidateUtil
{
    public static function get_miliseconds_gmt0()
    {
        $timezone = 0;
        $gm = gmdate("Y/m/j H:i:s", time() + 3600 * ($timezone + date("I")));
        return strtotime($gm) * 1000;
    }

    public static function get_sig($params, $private_key, $data_params)
    {
        $str_sig = '';
        foreach ($params as $key => $param) {
            if (isset($data_params[$param]))
                $str_sig .= $data_params[$param];
        }
        $str_sig .= $private_key;
        return hash('sha256', $str_sig);
    }
}