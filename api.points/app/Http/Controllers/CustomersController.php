<?php
namespace App\Http\Controllers;
/**
* 
*/

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Classes\Paid_Payment;
use App\Models\Customer;

class CustomersController extends Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function register(Request $request){
		$check_items = ['service_id','payment_id' , 'companyName', 'companyNameKana' , 'representativeSei', 'representativeMei' , 'representativeSeiKana' , 'representativeMeiKana', 'zipCode', 'prefecture', 'address1', 'address2', 'clerkSei', 'clerkMei', 'clerkSeiKana', 'clerkMeiKana', 'tel', 'email'];
		$ret = $this->validate_param($check_items);
        if ($ret) return $ret;

        //Access only paid jp payment
        $payment_id = $request->payment_id;
        
        if($payment_id != $this->_paidjpId){
        	return $this->error(1004);
        }

        $service_id = $request->service_id;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
        $paymentHandler = $this->getPaymentHandler($payment_id);

        $customer = Customer::member($auth_id, $payment_id ,$service_id)->first();
        if($customer){
        	$b2bMemberId = $customer->customer_id;
        	$this->body['data'] = [
        		'customer_id' => $customer->customer_id
        	];

        	return $this->output($this->body);
        }

        
        $b2bMemberId = $this->generateRandomMemberId();
        $body = $request->except(['payment_id']);
        $body['b2bMemberId'] = $b2bMemberId;
        $result = $paymentHandler->memberRegister($body);
        if($result['success']){
        	$data = $result['data'];
        	$customer = new Customer();
        	$customer->user_id = $auth_id;
        	$customer->customer_id = $data->b2bMemberId;
        	$customer->payment_id = $payment_id;
        	$customer->service_id = $service_id;
        	$customer->save();
        	$this->body['data'] = [
        		'customer_id' => $data->b2bMemberId
        	];
        	return $this->output($this->body);
        }
        else{
        	$detail = $result['detail'];
        	return $this->error_detail(1014, $detail);
        }
	}

	

	private function generateRandomMemberId($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $randomString .= '_'.microtime();

	    return substr($randomString, 0 , 20);
	}
}