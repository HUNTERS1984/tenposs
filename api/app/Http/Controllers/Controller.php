<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $message = array(
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
        '1005' => 'Unknown error.',
        '1006' => 'Email not correct',
        '1007' => 'Address does not exist',
        '1008' => 'Can not send email',
        '1009' => 'Accout is not active',
        '1010' => 'Create Room Success.',
    );
    protected $body = array(
        'code' => '1000',
        'message' => 'OK',
        'data' => array()
    );
    function output($body = array()) {
        return Response::json($this->body);
    }

    function error($code = 1005) {
        $this->body['code'] = $code;
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array();
        return $this->output($this->body);
    }

    function error_detail($code = 1005, $detail) {
        $this->body['code'] = $code;
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array('detail' => $detail);
        return $this->output($this->body);
    }

    protected function validate_param($params, $data = null) {
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
