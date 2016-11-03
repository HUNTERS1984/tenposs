<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Payment;
use App\Models\BillingPlan;
use App\Models\BillingAgreement;
use Illuminate\Http\Request;
use PaypalPayment;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Currency;
use PayPal\Api\ChargeModel;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use PayPal\Api\AgreementStateDescriptor;
use App\Models\Point;

class PaymentController extends Controller{
    
    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId = 'ARcuagIArin9BeOI0Y5R6SL-KwMSDtkAvMvGxkpK8k-Opjq2QlDytdoPON7iJmAdqZFbkj_XZXTP4bK6';
    private $_ClientSecret='EOZAVC6mbHfB8R7H4MufjcREXWrAfEW0tK7_aPBXIk6XUq8SMxbf1L57gbr6Rm5ioPVOSHBITKohQpeN';

  
    public function __construct()
    {

        $this->_apiContext = PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        $config = config('paypal_payment'); // Get all config items as multi dimensional array
        
        $flatConfig = array_dot($config); // Flatten the array with dots

        $this->_apiContext->setConfig($flatConfig); 
    }

    public function createWebhook(Request $request)
    {
        $check_items = array('url');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin') {
            return $this->error(9997);
        } 

        $webhook = new \PayPal\Api\Webhook();
        $baseUrl = url();
        $webhook->setUrl(Input::get('url'));

        $webhookEventTypes = array();
        $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"PAYMENT.AUTHORIZATION.CREATED"
            }'
        );
        $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"PAYMENT.AUTHORIZATION.VOIDED"
            }'
        );
        $webhook->setEventTypes($webhookEventTypes);
        $request = clone $webhook;

        try {
            $output = $webhook->create($this->_apiContext);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }


    public function createBillingPlan(Request $request)
    {
        $check_items = array('service_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin') {
            return $this->error(9997);
        } 

        $plan = new Plan();
        $plan->setName('Point Service Monthly Plan')
        ->setDescription('Point Service Monthly Plan')
        ->setType('fixed');
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("1")
            ->setCycles("1")
            ->setAmount(new Currency(array('value' => 25, 'currency' => 'USD')));
       
        // $chargeModel = new ChargeModel();
        // $chargeModel->setType('SHIPPING')
        //     ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));

        //$paymentDefinition->setChargeModels(array($chargeModel));

        $merchantPreferences = new MerchantPreferences();
        $baseUrl = url();

        $merchantPreferences->setReturnUrl("$baseUrl/api/v1/excecuteagreement?success=true")
        ->setCancelUrl("$baseUrl/api/v1/excecuteagreement?success=false")
        ->setAutoBillAmount("yes")
        ->setInitialFailAmountAction("CONTINUE")
        ->setMaxFailAttempts("0")
        ->setSetupFee(new Currency(array('value' => 25, 'currency' => 'USD')));


        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        $request = clone $plan;
        try {
            $output = $plan->create($this->_apiContext);

            $patch = new Patch();

            $value = new PayPalModel('{
                   "state":"ACTIVE"
                 }');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $output->update($patchRequest, $this->_apiContext);

            $plan = Plan::get($output->getId(), $this->_apiContext);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }



        $billingPlan = new BillingPlan();
        $billingPlan->service_id = Input::get('service_id');
        $billingPlan->paypal_billing_plan_id = $plan->getId();
        $billingPlan->save();
        $this->body['data'] = $plan->toArray();
        return $this->output($this->body);
    }

    public function billingPlan(){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin') {
            return $this->error(9997);
        } 

        try {
            $params = array('page_size' => '10');
            $planList = Plan::all($params, $this->_apiContext);
            $this->body['data'] = $planList->toArray();
            return $this->output($this->body);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }
    }
    
    public function getBillingPlan($id){
        
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin') {
            return $this->error(9997);
        } 

        try {

            $billingPlan = BillingPlan::find($id);
            if (!$billingPlan)
            {
                return $this->error(1004);
            }

            $plan = Plan::get($billingPlan->paypal_billing_plan_id, $this->_apiContext);
            $this->body['data'] = $plan->toArray();
            return $this->output($this->body);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }
    }
    public function deleteBillingPlan($id){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin') {
            return $this->error(9997);
        } 

        $billingPlan = BillingPlan::find($id);
        if (!$billingPlan)
        {
            return $this->error(1004);
        }

        try {
            $plan = Plan::get($billingPlan->paypal_billing_plan_id, $this->_apiContext);
            $result = $plan->delete($this->_apiContext);

            $billingPlan->delete();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        return $this->output($this->body);

    }

    public function updateBillingPlan($id){
        
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin') {
            return $this->error(9997);
        } 

        try {

            $billingPlan = BillingPlan::find($id);
            if (!$billingPlan)
            {
                return $this->error(1004);
            }

            $plan = Plan::get($billingPlan->paypal_billing_plan_id, $this->_apiContext);

            $patch = new Patch();

            $value = new PayPalModel('{
                   "state":"ACTIVE"
                 }');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $plan->update($patchRequest, $this->_apiContext);


            $plan = Plan::get($plan->getId(), $this->_apiContext);

            $this->body['data'] = $plan->toArray();
            return $this->output($this->body);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }
    }


    public function createBillingAgreement($plan_id){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');


        $agreement = new Agreement();

        $agreement->setName('Base Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate('2019-06-17T9:45:04Z');
        
        $billingPlan = BillingPlan::find($plan_id);
        if (!$billingPlan)
        {
            return $this->error(1004);
        }

        $createdPlan = Plan::get($billingPlan->paypal_billing_plan_id, $this->_apiContext);

        $plan = new Plan();
        $plan->setId($createdPlan->getId());
        $agreement->setPlan($plan);
        //Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);
        //Add Shipping Address
        // $shippingAddress = new ShippingAddress();
        // $shippingAddress->setLine1('111 First Street')
        //     ->setCity('Saratoga')
        //     ->setState('CA')
        //     ->setPostalCode('95070')
        //     ->setCountryCode('US');
        // $agreement->setShippingAddress($shippingAddress);
        
        $request = clone $agreement;
       
        try {
            $agreement = $agreement->create($this->_apiContext);
            $approvalUrl = $agreement->getApprovalLink();
            $billingAgreement = new BillingAgreement();
            $billingAgreement->billing_plan_id = $plan_id;
            $query = parse_url($approvalUrl, PHP_URL_QUERY);
            parse_str($query, $params);
            $billingAgreement->paypal_token = $params['token'];
            $billingAgreement->user_id = $auth_id;
            $billingAgreement->status = 0;
            $billingAgreement->save();

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        $this->body['data'] = $billingAgreement->toArray();
        $this->body['data']['approveUrl'] = $approvalUrl;
        return $this->output($this->body);
  
    }

    public function suspendBillingAgreement($id){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        $billingAgreement = BillingAgreement::find($id);
        if (!$billingAgreement)
        {
            return $this->error(1004);
        }

        try {

            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Suspending the agreement");

            $agreement = Agreement::get($billingAgreement->paypal_billing_agreement_id, $this->_apiContext);

            $agreement->suspend($agreementStateDescriptor, $this->_apiContext);

            $billingAgreement->status = 0;
            $billingAgreement->save();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        return $this->output($this->body);

    }

    public function updateBillingAgreement($id){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        $billingAgreement = BillingAgreement::find($id);
        if (!$billingAgreement)
        {
            return $this->error(1004);
        }

        try {

            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Reactivating the agreement");

            $agreement = Agreement::get($billingAgreement->paypal_billing_agreement_id, $this->_apiContext);

            $agreement->reActivate($agreementStateDescriptor, $this->_apiContext);

            $billingAgreement->status = 1;
            $billingAgreement->save();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        return $this->output($this->body);

    }


    //luong.hong.quan-facilitator-1@mqsolutions.vn/12345678
    public function excecuteAgreement(){
        $agreement = new Agreement();

        $token = $_GET['token'];

        $agreement = new \PayPal\Api\Agreement();
        try {
            // ## Execute Agreement
            // Execute the agreement by passing in the token
            $agreement->execute($token, $this->_apiContext);
            $agreement = Agreement::get($agreement->getId(), $this->_apiContext);
            
            $billingAgreement = BillingAgreement::where('paypal_token', '=', $token)->first();
            $billingAgreement->paypal_billing_agreement_id = $agreement->getId();
            $billingAgreement->status = 1;
            $billingAgreement->save();

            $point = Point::where('auth_user_id', '=', $billingAgreement->user_id)->first();

            if (!$point) {
                $point = new Point();
                $point->auth_user_id = $billingAgreement->user_id;
                $point->points = 5000;
                $point->miles = 0;
                $point->active = 1;
                $point->save();
            } else {
                $point->points += 5000;
                $point->save();
            }

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        $this->body['data'] = $billingAgreement->toArray();
        return $this->output($this->body);
  
    }

    public function billingTransactions($id){

        $billingAgreement = BillingAgreement::find($id);

        if (!$billingAgreement)
        {
            return $this->error(1004);
        }

        $params = array('start_date' => date('Y-m-d', strtotime('-15 years')), 'end_date' => date('Y-m-d', strtotime('+5 days')));

        try {
            $result = Agreement::searchTransactions($billingAgreement->paypal_billing_agreement_id, $params, $this->_apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        $this->body['data'] = $result->toArray();
        return $this->output($this->body);
  
    }

}