<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 9/19/16
 * Time: 6:14 AM
 */

namespace App\Utils;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class HttpRequestUtil
{
    protected static $_instance = null;

    public function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function post_data_return_boolean($service_url, $curl_post_data)
    {
        try {
            Log::info($service_url);
            Log::info(json_encode($curl_post_data));
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen(json_encode($curl_post_data)))
            );
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                Log::error(json_encode($info));
                return FALSE;
            }
            curl_close($curl);
            $decoded = json_decode($curl_response);
            if (isset($decoded->code) && $decoded->code == '1000') {
                return TRUE;
            } else {
                Log::error(json_encode($decoded));
                return FALSE;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return FALSE;
        }
    }

    public function get_data_with_token($service_url, $token)
    {
        try {
            Log::info($service_url);
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
//            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                )
            );
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                Log::error(json_encode($info));
                return null;
            }
            curl_close($curl);
            $decoded = json_decode($curl_response);
            if (isset($decoded->code) && $decoded->code == '1000') {
                return $decoded->data;
            } else {
                Log::error(json_encode($decoded));
                return null;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    public function post_data_with_token($service_url, $data_params, $token)
    {
        try {
            $data_params = json_encode($data_params);
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token)
            );
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                Log::error(json_encode($info));
                return json_encode($info);
            }
            curl_close($curl);
            return $curl_response;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}