<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Laravel\Lumen\Routing\Controller as BaseController;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Classes\Payment\Paid_Payment;
use App\Classes\Payment\Stripe_Payment;

class Controller extends BaseController
{
    protected $message = array(
        '1000' => 'OK.',
        '9994' => 'Point is not enought.',
        '9995' => 'Cannot login.',
        '9996' => 'User existed.',
        '9997' => 'Permission denied.',
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
        '1009' => 'Account is not active',
        '1010' => 'Create Room Success.',
        '1011' => 'Time expire.',
        '1012' => 'Parameter sig not exist.',
        '1013' => 'Parameter sig is not valid.',
        '1014' => 'Create new account failed',
        '10010' => 'The token is invalid',
        '10011' => 'Token is no longer valid because it has expired.',
        '10012' => 'Token exception.',
        '10013' => 'Token not match.',
        '11002' => 'Token not provided',
        '99941' => 'Point use is over max',
        '99953' => 'User not existed.',
        '99954' => 'User have request',
        '99955' => 'User not have request',
    );
    protected $body = array(
        'code' => '1000',
        'message' => 'OK',
        'data' => array()
    );

    //Payment id
    protected $_paypalId; 
    protected $_stripeId;
    protected $_paidjpId;

    public function __construct()
    {
        $payment_common = config('payment_common');
        $this->_paypalId = $payment_common['PAYMENT_ID']['PAYPAL'];
        $this->_stripeId = $payment_common['PAYMENT_ID']['STRIPE'];
        $this->_paidjpId = $payment_common['PAYMENT_ID']['PAIDJP'];
    }

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

    protected function validateAuth($acceptRoles = array())
    {
        $data_token = JWTAuth::parseToken()->getPayload();
        if(!$data_token) $this->error(9997);

        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        if(count($acceptRoles) == 0) return false;

        if (!in_array($auth_role, $acceptRoles)) {
            return $this->error(9997);
        } 
        return false;
    }

    protected function getPaymentHandler($paymentId)
    {
        $paymentHandler = false;
        switch ($paymentId) {
            case $this->_stripeId:
                $paymentHandler = new Stripe_Payment();
                break;
            case $this->_paidjpId:
                $paymentHandler = new Paid_Payment();
                break;
        }
        return $paymentHandler;
    }
}
