<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 8/22/16
 * Time: 6:00 AM
 */

namespace App\Utils;


class ValidateUtil
{

    public static function getDateMilisecondGMT0()
    {
        $timezone = 0;
        $gm = gmdate("Y/m/j H:i:s", time() + 3600 * ($timezone + date("I")));
        return strtotime($gm) * 1000;
    }
}