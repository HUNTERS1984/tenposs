<?php
/**
* Stripe Gateway payment
*/
namespace App\Classes\Payment;
use App\Classes\Base\PaymentGateWay;
use \Stripe\Stripe as Stripe;
use \Stripe\Plan as StripePlan;
use \Stripe\Customer as StripeCustomer;
use \Stripe\Subscription as StripeSubscription;
use \Stripe\Charge as StripeCharge;
use App\Models\Customer;
class Stripe_Payment extends PaymentGateWay
{
	const TEST_SECRET_KEY  = 'sk_test_8h4yEvAghmPcVddcB2f5VGHT';

	const TEST_PUBLISH_KEY  = 'pk_test_gDSETkvMJYL0YPL0yiTdvjuh';

	const LIVE_SECRET_KEY  = 'sk_live_jBmec0aygMqpIJ9VrKLgrcYf';

	const LIVE_PUBLISH_KEY  = 'pk_live_yGgpjQk2llYjjpK7RvchOSQv';


	public static $secretKey;

	public static $publishKey;

	private $_stripeId = 2;
	/**
	 * plan parameter
	 * @var array
	 */
	protected $planDetail = [];

	public function set_option($option = array())
	{
		$option = $this->shortcode_atts(array(
			'sp_sandbox' => true,
			'test_secret_key' => '',
			'live_secret_key' => '',
		), $option);

		$this->is_sandbox = (boolean)$option['sp_sandbox'];
	}

	public function on_construct(){

		if($this->is_sandbox){
			self::setSecretKey(self::TEST_SECRET_KEY);
		}
		else{
			self::setSecretKey(self::LIVE_SECRET_KEY);
		}

		$secretKey = self::getSecretKey();		
		Stripe::setApiKey($secretKey);
	}

	public static function setSecretKey($secretKey)
	{
		self::$secretKey = $secretKey;
	}

	public static function setPublishKey($publishKey)
	{
		self::$publishKey = $publishKey;
	}

	public static function getSecretKey()
	{
		return self::$secretKey;
	}

	public static function getPublishKey()
	{
		return self::$publishKey;
	}

	public function setPlanDetail($planDetail)
	{
		$this->planDetail = $planDetail;
	}

	public function getBillingPlan($planId)
	{		
		try {
			return StripePlan::retrieve($planId);
		} catch(\Stripe\Error\Card $e) {
		  	// Since it's a decline, \Stripe\Error\Card will be caught
		  	// $body = $e->getJsonBody();
		  	// $err  = $body['error'];

		  	// print('Status is:' . $e->getHttpStatus() . "\n");
		  	// print('Type is:' . $err['type'] . "\n");
		  	// print('Code is:' . $err['code'] . "\n");
		  	// // param is '' in this case
		  	// print('Param is:' . $err['param'] . "\n");
		  	// print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  	// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  	// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  	// Authentication with Stripe's API failed
		  	// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  	// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  	// Display a very generic error to the user, and maybe send
		  	// yourself an email
		} catch (Exception $e) {
		  	// Something else happened, completely unrelated to Stripe
		}	
		return false;
	}

	public function createPlan()
	{
		$planDetail = $this->planDetail;

		try {
			return StripePlan::create($planDetail);
		} catch(\Stripe\Error\Card $e) {
		  	// Since it's a decline, \Stripe\Error\Card will be caught
		  	// $body = $e->getJsonBody();
		  	// $err  = $body['error'];

		  	// print('Status is:' . $e->getHttpStatus() . "\n");
		  	// print('Type is:' . $err['type'] . "\n");
		  	// print('Code is:' . $err['code'] . "\n");
		  	// // param is '' in this case
		  	// print('Param is:' . $err['param'] . "\n");
		  	// print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  	// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  	// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  	// Authentication with Stripe's API failed
		  	// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  	// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  	// Display a very generic error to the user, and maybe send
		  	// yourself an email
		} catch (Exception $e) {
		  	// Something else happened, completely unrelated to Stripe
		}	
		return false;
	}

	public function createBillingPlan($type){

		if($type == 1){
            $planDetail = [
                'name' => 'Basic Yearly Plan',
                'id' => 'basic-yearly_'.time(),
                'interval' => 'year',
                'currency' => 'usd',
                'amount' => '300'
            ];
        }
        else{
            $planDetail = [
                'name' => 'Basic Monthly Plan',
                'id' => 'basic-monthly_'.time(),
                'interval' => 'month',
                'currency' => 'usd',
                'amount' => '25'
            ];
        }
        
        $this->setPlanDetail($planDetail);
        $plan = $this->getBillingPlan($planDetail['id']);
        if(!$plan){
            $plan = $this->createPlan(); 
            if(!$plan) {
                return false;
            }
        } 
        return $plan;	
	}



	public function createCustomer($customerDetail)
	{
		try {
			return StripeCustomer::create($customerDetail);
		} catch(\Stripe\Error\Card $e) {
		  	// Since it's a decline, \Stripe\Error\Card will be caught
		  	// $body = $e->getJsonBody();
		  	// $err  = $body['error'];

		  	// print('Status is:' . $e->getHttpStatus() . "\n");
		  	// print('Type is:' . $err['type'] . "\n");
		  	// print('Code is:' . $err['code'] . "\n");
		  	// // param is '' in this case
		  	// print('Param is:' . $err['param'] . "\n");
		  	// print('Message is:' . $err['message'] . "\n");
		  	$this->showError($e);
		} catch (\Stripe\Error\RateLimit $e) {
			$this->showError($e);
		  	// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
			$this->showError($e);
		  	// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
			$this->showError($e);
		  	// Authentication with Stripe's API failed
		  	// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
			$this->showError($e);
		  	// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
			$this->showError($e);
		  	// Display a very generic error to the user, and maybe send
		  	// yourself an email
		} catch (Exception $e) {
			$this->showError($e);
		  	// Something else happened, completely unrelated to Stripe
		}	
		return false;
	}	

	public function getCustomer($customerId)
	{
		try {
			$cu = StripeCustomer::retrieve($customerId);
			return $cu;
		} catch(\Stripe\Error\Card $e) {
		  	// Since it's a decline, \Stripe\Error\Card will be caught
		  	// $body = $e->getJsonBody();
		  	// $err  = $body['error'];

		  	// print('Status is:' . $e->getHttpStatus() . "\n");
		  	// print('Type is:' . $err['type'] . "\n");
		  	// print('Code is:' . $err['code'] . "\n");
		  	// // param is '' in this case
		  	// print('Param is:' . $err['param'] . "\n");
		  	// print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  	// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  	// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  	// Authentication with Stripe's API failed
		  	// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  	// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  	// Display a very generic error to the user, and maybe send
		  	// yourself an email
		} catch (Exception $e) {
		  	// Something else happened, completely unrelated to Stripe
		}	
		return false;
	}

	public function deleteCustomer($customerId)
	{
		try {
			$cu = StripeCustomer::retrieve($customerId);
			$cu->delete();
			return true;
		} catch(\Stripe\Error\Card $e) {
		  	// Since it's a decline, \Stripe\Error\Card will be caught
		  	// $body = $e->getJsonBody();
		  	// $err  = $body['error'];

		  	// print('Status is:' . $e->getHttpStatus() . "\n");
		  	// print('Type is:' . $err['type'] . "\n");
		  	// print('Code is:' . $err['code'] . "\n");
		  	// // param is '' in this case
		  	// print('Param is:' . $err['param'] . "\n");
		  	// print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  	// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  	// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  	// Authentication with Stripe's API failed
		  	// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  	// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  	// Display a very generic error to the user, and maybe send
		  	// yourself an email
		} catch (Exception $e) {
		  	// Something else happened, completely unrelated to Stripe
		}	
		return false;
	}

	public function cancelSubscription($subscriptionId){
		
	}
	public function createSubscription($data = array()){
		try {
			return StripeSubscription::create($data);
		} catch (Exception $e) {
			return false;
		}
	}

	public function listCharges($params)
	{
		try {
			return StripeCharge::all($params);
		} catch (Exception $e) {
			return false;
		}
	}

	public function createBillingAgreement($authId, $paymentId, $billingPlan, $cardToken)
	{
		$serviceId = $billingPlan->service_id;
        //plan id from payment gateway
        $plan = $billingPlan->paypal_billing_plan_id;
        
		$customer = Customer::member($authId, $paymentId, $serviceId)->first();

        $customerDetail = [
            'source' => $cardToken,
            'plan' => $plan,
            'trial_end' => 'now'
        ];
        if(!$customer){
            //Create new customer and subscription
            $cu = $this->createCustomer($customerDetail);             

            if(!$cu) return false;
            $subscriptions = $cu->subscriptions;                
            $subscriptionId = $subscriptions->data[0]->id;

            //Regis new customer id
            $customer = new Customer;
            $customer->user_id = $authId;
            $customer->customer_id = $cu->id;
            $customer->payment_id = $this->_stripeId;
            $customer->service_id = $serviceId;
            $customer->save();
        }
        else{
            //Subscription with customer id
            $subscription = $this->createSubscription(['customer' => $customer->customer_id, 'plan' => $plan]);
            if(!$subscription) return false;
            $subscriptionId = $subscription->id;
        }

        return (object) [
        	'subscriptionId' => $subscriptionId
        ];
	}

	public function suspendBillingAgreement($customerId, $subscriptionId)
	{
		try {
			$cu = $this->getCustomer($customerId);
	        if(!$cu) return false;
	        $subscription = $cu->subscriptions->retrieve($subscriptionId);
	        $status = $subscription->status;
	        if($status != 'canceled'){
	        	$res = $cu->subscriptions->retrieve($subscriptionId)->cancel();	
	        }
	        return true;
	        
		} catch(\Stripe\Error\Card $e) {
		  	// Since it's a decline, \Stripe\Error\Card will be caught
		  	// $body = $e->getJsonBody();
		  	// $err  = $body['error'];

		  	// print('Status is:' . $e->getHttpStatus() . "\n");
		  	// print('Type is:' . $err['type'] . "\n");
		  	// print('Code is:' . $err['code'] . "\n");
		  	// // param is '' in this case
		  	// print('Param is:' . $err['param'] . "\n");
		  	// print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  	// Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  	// Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  	// Authentication with Stripe's API failed
		  	// (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  	// Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  	// Display a very generic error to the user, and maybe send
		  	// yourself an email
		} catch (Exception $e) {
		  	// Something else happened, completely unrelated to Stripe
		}
		return false;
		
	}
}