<?php

namespace App\Utils;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class HttpRequestUtil
{
    protected static $_instance = null;
    protected $_url = null;
    protected $_secret_key = null;

    public function __construct()
    {
        $this->_url = Config::get('api.url');
        $this->_secret_key = Config::get('api.secret_key');
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

    private function get_sig_param_by_function($function, $data_params)
    {
        $sig = '';
        $params = array();
        switch ($function) {
            case 'top':
                $params = Config::get('api.sig_top');
                break;
            case 'appinfo':
                $params = Config::get('api.sig_appinfo');
                break;
            case 'signup':
                $params = Config::get('api.sig_signup');
                break;
            case 'social_login':
                $params = Config::get('api.sig_social_login');
                break;
            case 'signin':
                $params = Config::get('api.sig_signin');
                break;
            case 'signout':
                $params = Config::get('api.sig_signout');
                break;
            case 'menu':
                $params = Config::get('api.sig_menu');
                break;
            case 'items':
                $params = Config::get('api.sig_items');
                break;
            case 'news':
                $params = Config::get('api.sig_news');
                break;
            case 'news':
                $params = Config::get('api.sig_news');
                break;
            case 'news':
                $params = Config::get('api.sig_news');
                break;
            case 'news_cat':
                $params = Config::get('api.sig_news_cat');
                break;
            case 'photo_cat':
                $params = Config::get('api.sig_photo_cat');
                break;
            case 'photo':
                $params = Config::get('api.sig_photo');
                break;
            case 'reserve':
                $params = Config::get('api.reserve');
                break;
            case 'coupon':
                $params = Config::get('api.sig_coupon');
                break;
            case 'profile':
                $params = Config::get('api.sig_profile');
                break;
            case 'profile':
                $params = Config::get('api.sig_profile');
                break;
            case 'social_profile':
                $params = Config::get('api.sig_social_profile');
                break;
            case 'staff_category':
                $params = Config::get('api.sig_staff_category');
                break;
            case 'staffs':
                $params = Config::get('api.sig_staffs');
                break;
            default:
                break;
        }
        if (count($params) > 0) {
            $sig = ValidateUtil::get_sig($params, $this->_secret_key, $data_params);
        }
        return $sig;
    }

    public function get_data($function, $data_params)
    {
        try {

            $data_params['time'] = ValidateUtil::get_miliseconds_gmt0();
            $data_params['sig'] = $this->get_sig_param_by_function($function, $data_params);
            $service_url = $this->_url . $function . '?' . http_build_query($data_params);

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

    public function post_data($function, $data_params)
    {
        try {
            $data_params['time'] = ValidateUtil::get_miliseconds_gmt0();
            $data_params['sig'] = $this->get_sig_param_by_function($function, $data_params);
            $data_params = json_encode($data_params);
            $service_url = $this->_url . $function;
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
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

}