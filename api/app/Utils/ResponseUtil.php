<?php
    namespace App\Utils;
   
    class ResponseUtil{
        public static $message = array(
            '1000' => 'OK.',
            '9994' => 'Point is not enought.',
            '9995' => 'Cannot login.',
            '9996' => 'User existed.',
            '9997' => 'Method is not valid.',
            '9998' => 'Token is invalid.',
            '9999' => 'Exception error.',
            '1001' => 'Can not connect to DB.',
            '1002' => 'Parameter is not enought.',
            '1003' => 'Parameter type is not valid.',
            '1004' => 'Parameter value is not valid.',
            '1005' => 'Unknown error.'
        );
        // Response body
        public static $body = array(
            'code' => '1000',
            'message' => 'OK',
            'data' => array()
        );

        public static function success($data) {
            self::$body['data'] = $data;
            return self::$body;
        }

        public static function error($code = 1005) {
            self::$body['code'] = $code;
            self::$body['message'] = self::$message[$code];
            self::$body['data'] = array();
            return self::$body;
        }

        public static function error_detail($code = 1005, $detail) {
            self::$body['code'] = $code;
            self::$body['message'] = self::$message[$code];
            self::$body['data'] = $detail;//array('detail' => $detail);
            return self::$body;
        }

        
    }