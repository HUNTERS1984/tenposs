<?php

/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 11/22/16
 * Time: 1:53 PM
 */
class Utilities
{
    public static function checkDateFormatYmd($str)
    {
        if (DateTime::createFromFormat('Y-m-d', $str) !== FALSE) {
            return true;
        }
        return false;
    }

    public static function get_dimension_from_time_type($time_type)
    {
        //ga:date,ga:year,ga:month,ga:week,ga:day
        //D ~ ga:date, W ~ ga:week, M ~ ga:month, Y ~ ga: year
        $dimension = 'ga:date';
        switch ($time_type) {
            case 'D':
                $dimension = "ga:date";
                break;
            case 'W':
                $dimension = "ga:week";
                break;
            case 'M':
                $dimension = "ga:month";
                break;
            case 'Y':
                $dimension = "ga:year";
                break;
            default:
                break;
        }
        return $dimension;
    }

    public static function get_report_type($type_alias)
    {

    }

    public static function get_list_metric()
    {
        return array('ga:users','ga:sessions','ga:screenviews','ga:bounceRate','ga:avgSessionDuration','ga:percentNewSessions');
    }
}