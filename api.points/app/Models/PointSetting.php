<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/31/16
 * Time: 5:39 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PointSetting extends Model
{
    protected $table = 'point_setting';

    static public function getPointSetting($app_id) {
        $point_setting = PointSetting::where('app_app_id', '=', $app_id)->first();
        if (!$point_setting) {
            $point_setting = new PointSetting();
            $point_setting->mile_to_point = 100;
            $point_setting->yen_to_mile = 1;
            $point_setting->bonus_miles_1 = 0;
            $point_setting->bonus_miles_2 = 0;
            $point_setting->max_point_use = 10000;
            $point_setting->rank1 = 0;
            $point_setting->rank2 = 0;
            $point_setting->rank3 = 0;
            $point_setting->rank4 = 0;
            $point_setting->payment_method = 0;
            $point_setting->app_app_id = $app_id;
            $point_setting->save();
        }

        return $point_setting;
    }
}