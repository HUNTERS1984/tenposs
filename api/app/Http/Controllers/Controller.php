<?php

namespace App\Http\Controllers;


use App\Utils\ValidateUtil;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Config;
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
        '1011' => 'Time expire.',
        '1012' => 'Parameter sig not exist.',
        '1013' => 'Parameter sig is not valid.',
    );
    protected $body = array(
        'code' => '1000',
        'message' => 'OK',
        'data' => array()
    );

    function output($body = array())
    {
        return Response::json($this->body);
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
                if ($param == 'time' && isset($data[$param]) && !$this->validate_time_expire($data[$param]))
                    return $this->error_detail(1011, 'Time expire');
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

    protected function validate_time_expire($time)
    {
        return true;
        /*
        $currentMilliseconds = ValidateUtil::getDateMilisecondGMT0();//round(microtime(true) * 1000);
        if (($currentMilliseconds - $time) < Config::get('api.time_expire') && ($currentMilliseconds - $time) >= 0)
            return true;
        return false;
        */
    }

    protected function validate_sig($params, $private_key, $data = null)
    {
        $str_sig = '';
        if (!$data)
            $data = Input::all();
        if (!array_key_exists('sig', $data))
            return $this->error_detail(1012, 'Parameter sig not exist.');
        $sig_param = $data['sig'];
        foreach ($params as $key => $param) {
            if (!is_array($param)) {
                if (isset($data[$param])) {
                    $str_sig .= $data[$param];
                }
            }
        }
        $str_sig .= $private_key;
        //dd($str_sig);die;
        $str_sig = hash('sha256', $str_sig);
        if (strtolower($str_sig) !== strtolower($sig_param))
            return $this->error_detail(1013, 'Parameter sig is not valid.');
        return 0;
    }

    protected function get_sig($params, $private_key, $time, $data = null)
    {
        $str_sig = '';
        if (!$data)
            $data = Input::all();
        foreach ($params as $key => $param) {
            if (!is_array($param)) {
                if ($param == 'time')
                    $str_sig .= $time;
                if (isset($data[$param]))
                    $str_sig .= $data[$param];

            }
        }
        $str_sig .= $private_key;
        //dd($str_sig);
        return hash('sha256', $str_sig);
    }

    protected function validate_param_test($params, $data = null)
    {
        if (!$data)
            $data = Input::all();

        foreach ($params as $key => $param) {
            if (!is_array($param)) {
                if ($param != 'time') {
                    if (!isset($data[$param])) {
                        return false;
                    }
                    //not null.
                    if ($data[$param] === '') {
                        return false;
                    }
                }
            } else {
                if (!isset($data[$key])) {
                    return false;
                }
                if (!is_array($data[$key])) {
                    return false;
                }
                $ret = $this->validate_param($param, $data[$key]);
                if ($ret) {
                    return $ret;
                }
            }
        }
        return true;
    }
}
