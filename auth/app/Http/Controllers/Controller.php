<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;

class Controller extends BaseController
{
    protected $message = array(
        '1000' => 'OK.',
        '9994' => 'Point is not enought.',
        '9995' => 'Cannot login.',
        '9996' => 'User existed.',
        '9997' => 'Permission denied',
        '9998' => 'Token is invalid.',
        '9999' => 'Exception error.',
        '1001' => 'Can not connect to DB.',
        '1002' => 'Parameter is not enought.',
        '1003' => 'Parameter type is not valid.',
        '1004' => 'Parameter value is not valid.',
        '1005' => 'Unknown error.',
        '1006' => 'Email not correct',
        '1007' => 'Address does not exist',
        '1008' => 'Can not send email',
        '1009' => 'Accout is not active',
        '1010' => 'Create Room Success.',
        '1011' => 'Time expire.',
        '1012' => 'Parameter sig not exist.',
        '1013' => 'Parameter sig is not valid.',
        '99950' => 'Email have not activated.',
        '99951' => 'Active code not exist.',
        '99952' => 'Active code expire.',
        '99953' => 'User not existed.',
        '99954' => 'Refresh token invalid.',
        '99955' => 'Auth invalid.',
        '99956' => 'Password not math.',
        '99957' => 'Method not allow.',
    );
    protected $body = array(
        'code' => '1000',
        'message' => 'OK',
        'data' => array()
    );

    function output($body = array())
    {
        return response()->json($this->body);
    }

    function error($code = 1005)
    {
        $this->body['code'] = $code;
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array();
        return $this->output($this->body);
    }

    function error_detail($code = 1005, $detail)
    {
        $this->body['code'] = $code;
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array('detail' => $detail);
        return $this->output($this->body);
    }

    protected function validate_param($params, $data = null)
    {

        if (!$data)
            $data = Input::all();
        foreach ($params as $key => $param) {
            if (!is_array($param)) {
                if (!isset($data[$param])) {
                    return $this->error_detail(1002, 'not found ' . $param);
                }
                //not null.
                if ($data[$param] === '') {
                    return $this->error_detail(1004, 'param: ' . $param . ' is null.');
                }
            } else {
                if (!isset($data[$key])) {
                    return $this->error_detail(1002, 'not found ' . $key);
                }
                if (!is_array($data[$key])) {
                    return $this->error(1003);
                }
                $ret = $this->validate_param($param, $data[$key]);
                if ($ret) {
                    return $ret;
                }
            }
        }
        return 0;
    }
}
