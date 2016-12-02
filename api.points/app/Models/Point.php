<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 10/31/16
 * Time: 5:39 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';

    static public function getPoint($user_id) {
        $point_info = Point::where('auth_user_id', '=', $user_id)->first();

        if (!$point_info) {
            $point_info = new Point();
            $point_info->auth_user_id = $user_id;
            $point_info->points = 0;
            $point_info->miles = 0;
            $point_info->active = 1;
            $point_info->save();
        }

        return $point_info;
    }
}