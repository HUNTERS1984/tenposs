<?php

namespace App\Utils;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class HttpRequestUtil
{
    protected static $_instance = null;
    protected $_url = null;
    protected $_secret_key = null;
    protected $_secret_key_app_info = null;
    protected $_basic_username = null;
    protected $_basic_password = null;

    public function __construct()
    {
        $this->_url = Config::get('api.url');
        $this->_secret_key = Config::get('api.secret_key');
        $this->_secret_key_app_info = "Tenposs@123";
        $this->_basic_username = "tenposs";
        $this->_basic_password = "Tenposs@123";
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function show_url()
    {
        $array = array('a' => 'b', 'c' => 1);
        $str = http_build_query($array);
        return $this->_url . $str;
    }

    private function get_sig_param_by_function($function, $data_params, $app_secret_key)
    {
        $sig = '';
        $params = array();
        switch ($function) {
            case 'app_secret_info':
                $params = Config::get('api.sig_app_secret_info');
                break;

            case 'news_detail':
                $params = Config::get('api.sig_news_detail');
                break;
            case 'coupon_detail':
                $params = Config::get('api.sig_coupon_detail');
                break;

            case 'staff_detail':
                $params = Config::get('api.sig_staff_detail');
                break;
            default:
                break;
        }
        if (count($params) > 0) {
            if ($function == 'get_app_by_domain')
                $sig = ValidateUtil::get_sig($params, $this->_secret_key, $data_params);
            else if ($function == 'app_secret_info')
                $sig = ValidateUtil::get_sig($params, $this->_secret_key_app_info, $data_params);
            else
                $sig = ValidateUtil::get_sig($params, $app_secret_key, $data_params);
        }
        return $sig;
    }

    public function get_data($function, $data_params, $app_secret_key = null)
    {
        try {

            $data_params['time'] = ValidateUtil::get_miliseconds_gmt0();
            $data_params['sig'] = $this->get_sig_param_by_function($function, $data_params, $app_secret_key);
            $service_url = $this->_url . $function . '?' . http_build_query($data_params);
//            print_r($service_url);
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
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

    public function post_data($function, $data_params, $app_secret_key = null)
    {
        try {
            $data_params['time'] = ValidateUtil::get_miliseconds_gmt0();
            $data_params['sig'] = $this->get_sig_param_by_function($function, $data_params, $app_secret_key);
            $data_params = json_encode($data_params);
            $service_url = $this->_url . $function;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_params))
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

    public function post_data_file($url, $data_params, $token)
    {
        try {
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: multipart/form-data',
                    'Authorization: Bearer ' . $token
                )
            );
            $curl_response = curl_exec($curl);

            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                Log::error(json_encode($info));
                return false;
            }
            curl_close($curl);
//            print_r($curl_response);
            $decoded = json_decode($curl_response);
            if (isset($decoded->code) && $decoded->code == '1000') {
                return true;
            } else {
                Log::error(json_encode($decoded));
                return false;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function get_data_with_token($service_url, $token)
    {
        try {
            Log::info($service_url);
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
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

    public function post_data_with_basic_auth($service_url, $data_params)
    {
        try {

//            Log::info($service_url);
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_params));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERPWD, $this->_basic_username . ":" . $this->_basic_password);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json')
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

    public function get_data_with_basic_auth($service_url, $data_params)
    {
        try {

//            Log::info($service_url);
            if (count($data_params) > 0)
                $url = $service_url . '?' . http_build_query($data_params);
            else
                $url = $service_url;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_params));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERPWD, $this->_basic_username . ":" . $this->_basic_password);
            curl_setopt($curl, CURLOPT_POST, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json')
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

}