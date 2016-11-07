<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 11/7/16
 * Time: 10:19 PM
 */

namespace App\Utils;


use Illuminate\Http\Request;

class HttpUtils
{
    public static function get_refresh_token_url(Request $request, $id_code, $refresh_token)
    {
        $full_path = $request->fullUrl();
        $pos = strpos($request->url(), $request->path());
        if ($pos > 0) {
            return substr($request->url(), 0, $pos) . 'v1/auth/access_token/' . $id_code . '/' . $refresh_token;
        }
        return $full_path . 'v1/auth/access_token/' . $id_code . '/' . $refresh_token;;
    }
}