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
use App\Models\PointHistory;
use App\Classes\Payment\Stripe_Payment;
use App\Models\Customer;
use App\Models\Purchase;

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
     *string $_ClientSecrret
     */
    private $_ClientId = 'ARcuagIArin9BeOI0Y5R6SL-KwMSDtkAvMvGxkpK8k-Opjq2QlDytdoPON7iJmAdqZFbkj_XZXTP4bK6';
    private $_ClientSecret='EOZAVC6mbHfB8R7H4MufjcREXWrAfEW0tK7_aPBXIk6XUq8SMxbf1L57gbr6Rm5ioPVOSHBITKohQpeN';

    private $_spPayment;

    const MONTHLY_TYPE = 0;
    const YEARLY_TYPE = 1;

    public function __construct(Stripe_Payment $stripe_payment)
    {
        parent::__construct();

        $this->_spPayment = $stripe_payment;

        $this->_apiContext = PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        $config = config('paypal_payment'); // Get all config items as multi dimensional array        
        $flatConfig = array_dot($config); // Flatten the array with dots
        
        $this->_apiContext->setConfig($flatConfig);         
    }

    private function validUrl($url)
    {
        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
        $regex .= "(\:[0-9]{2,5})?"; // Port 
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

        if(preg_match("/^$regex$/", $url)) { 
            return true; 
        } 
        return false;
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
        $url = Input::get('url');
        if(!$this->validUrl($url)){
            return $this->error(1004);
        }

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
        } 
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        return $this->output($this->body);
    }

    /**
     * Create billing plan for service
     * Billing plan only created by Admin
     * @param  string $service_id : service id ????
     * @param int $payment_id payment gateway id
     * @return json
     */
    public function createBillingPlan(Request $request)
    {
        $check_items = array('service_id', 'payment_id');
        $ret = $this->validate_param($check_items);
        if ($ret) return $ret;

        //Validate auth and role
        $validateAuth = $this->validateAuth(['admin']);
        if($validateAuth) return $validateAuth;

        //Validate billing frequent type
        $availableType = [self::MONTHLY_TYPE, self::YEARLY_TYPE];
        $type = !is_null(Input::get('type')) ? Input::get('type') : self::MONTHLY_TYPE;
        
        if(!in_array($type, $availableType)) {
            return $this->error(1004);
        }

        $serviceId = $request->service_id;
        $payment_id = $request->payment_id;

        if($payment_id == 0) return $this->error(1004);
        

        if($payment_id == $this->_paypalId){

            if ($type == self::YEARLY_TYPE) // yearly
            {
                $price = 300;
                $plan = new Plan();
                $plan->setName('Point Service Yearly Plan')
                ->setDescription('Point Service Yearly Plan')
                ->setType('fixed');
                $paymentDefinition = new PaymentDefinition();
                $paymentDefinition->setName('Regular Payments')
                    ->setType('REGULAR')
                    ->setFrequency('Year')
                    ->setFrequencyInterval("1")
                    ->setCycles("1")
                    ->setAmount(new Currency(array('value' => $price, 'currency' => 'USD')));
            } else { // monthly
                $price  = 25;  
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
                    ->setAmount(new Currency(array('value' => $price, 'currency' => 'USD')));
            }  

            $merchantPreferences = new MerchantPreferences();
            $baseUrl = url();

            $merchantPreferences->setReturnUrl("$baseUrl/api/v1/excecuteagreement?success=true")
            ->setCancelUrl("$baseUrl/api/v1/excecuteagreement?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => $price, 'currency' => 'USD')));


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

            $this->setBillingPlan(Input::get('service_id'), $plan->getId(), $type, $this->_paypalId);
            $this->body['data'] = $plan->toArray();
        }
        else{         
            $paymentHandler = $this->getPaymentHandler($payment_id);
            if(!$paymentHandler) return $this->error(1004);
            Log::info('Create new billing plan', [
                'paymentId' => $payment_id,
                'serviceId' => $serviceId
            ]);
            $plan = $paymentHandler->createBillingPlan($type);         
            if(!$plan) return $this->error(9999);
            
            $this->setBillingPlan($serviceId, $plan->id, $type, $payment_id);
            $this->body['data'] = $plan;
        }   
        return $this->output($this->body);         
    }
    
    public function billingPlan(){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin' && $auth_role != 'client') {
            return $this->error(9997);
        } 

        $check_items = array('type');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            // $params = array('page_size' => '10');
            // $planList = Plan::all($params, $this->_apiContext);
            $planList = BillingPlan::whereType(Input::get('type'))->get();
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

        if ($auth_role != 'admin' && $auth_role != 'client') {
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

    public function getUserBillingPlan(){
        
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        if ($auth_role != 'admin' && $auth_role != 'client') {
            return $this->error(9997);
        } 

        try {

            $billingAgreement = BillingAgreement::whereUserId($auth_id)->whereStatus(1)->first();
            if (!$billingAgreement)
            {
                return $this->error(1004);
            }

            $this->body['data'] = $billingAgreement->toArray();
            $this->body['data']['billingplan'] = BillingPlan::find($billingAgreement->billing_plan_id);
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

        // try {
        //     $plan = Plan::get($id, $this->_apiContext);
        //     $result = $plan->delete($this->_apiContext);
        // } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        //     return $this->error(9999);
        // }


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

    /**
     * Creating Subscriptions for user
     * @param  Request $request 
     * @param  int  $plan_id billing plan id
     * @return json
     */
    public function createBillingAgreement(Request $request, $plan_id){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');
    
        
        $billingPlan = BillingPlan::find($plan_id);

        if (!$billingPlan){
            return $this->error(1004);
        }
        
        $paymentId = $billingPlan->payment_id;

        $cardToken = Input::get('cardToken');
        if($paymentId == $this->_stripeId) {
            if(!$cardToken) return $this->error(1004);
        }

        



        if($paymentId == $this->_paypalId){
            $agreement = new Agreement();

            $agreement->setName('Base Agreement')
                ->setDescription('Basic Agreement')
                ->setStartDate(gmdate('Y-m-d\TH:i:s\Z',strtotime("+1 days")));

            $createdPlan = Plan::get($billingPlan->paypal_billing_plan_id, $this->_apiContext);

            $plan = new Plan();
            $plan->setId($createdPlan->getId());
            $agreement->setPlan($plan);
            //Add Payer
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);

            
            $request = clone $agreement;
           
            try {
                $agreement = $agreement->create($this->_apiContext);
                $approvalUrl = $agreement->getApprovalLink();
                // $billingAgreement = new BillingAgreement();
                // $billingAgreement->billing_plan_id = $plan_id;
                $query = parse_url($approvalUrl, PHP_URL_QUERY);
                parse_str($query, $params);
                $billingAgreement = $this->setBillingAgreement($plan_id, $auth_id, $params['token']);
                // $billingAgreement->paypal_token = $params['token'];
                // $billingAgreement->user_id = $auth_id;
                // $billingAgreement->status = 1;
                // $billingAgreement->save();

            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                dd($ex);
                return $this->error(9999);
            }

            $this->body['data'] = $billingAgreement->toArray();
            $this->body['data']['approveUrl'] = $approvalUrl;
        }
        else{        
            

            $billingPlanId = $billingPlan->id;
            $serviceId = $billingPlan->service_id;
            //plan id from payment gateway
            $plan = $billingPlan->paypal_billing_plan_id;

            $paymentHandler = $this->getPaymentHandler($paymentId);
            if(!$paymentHandler) return $this->error(1004);

            $existBillingAgm = BillingAgreement::where('billing_plan_id',$billingPlanId)->where('user_id',$auth_id)->first();

            if(!$existBillingAgm){                
                $result = $paymentHandler->createBillingAgreement($auth_id, $paymentId, $billingPlan, $cardToken);
                if(!$result) return $this->error(9999);
                $subscriptionId = $result->subscriptionId;
                $billingAgreement = $this->setBillingAgreement($plan_id, $auth_id, $cardToken, $subscriptionId);
                $this->body['data'] = $billingAgreement->toArray();
                $this->body['data']['approveUrl'] = null;
            }
            else{
                $this->body['data'] = $existBillingAgm->toArray();
                $this->body['data']['approveUrl'] = null;
            }
        }
        

        
        return $this->output($this->body);
  
    }    

    /**
     * Cancels a customer’s subscription
     * @param  int $billAgrId billing plan id
     * @return json
     */
    public function suspendBillingAgreement($billAgrId){
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');
        $auth_role = $data_token->get('role');

        $billingAgreement = BillingAgreement::find($billAgrId);

        if (!$billingAgreement) {
            return $this->error(1004);
        }
        

        $billingPlan = $billingAgreement->billingPlan;
        $payment_id = $billingPlan->payment_id;
        $serviceId = $billingPlan->service_id;

        if($payment_id == $this->_paypalId){
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
        }
        else{
            $paymentHandler = $this->getPaymentHandler($payment_id);
            if(!$paymentHandler) return $this->error(1004);

            $customer = Customer::member($auth_id, $payment_id, $serviceId)->first();
            if(!$customer) return $this->error(1004);

            $subscriptionId = $billingAgreement->paypal_billing_agreement_id;
            $res = $paymentHandler->suspendBillingAgreement($customer->customer_id, $subscriptionId);

            if(!$res) return  $this->error(9999);
                       
            $billingAgreement->status = 0;
            $billingAgreement->save();            
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

            $agreement = Agreement::get($billingAgreement->id, $this->_apiContext);

            $agreement->reActivate($agreementStateDescriptor, $this->_apiContext);

            $billingAgreement->status = 1;
            $billingAgreement->save();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        return $this->output($this->body);

    }

    public function test()
    {
        dd(1);
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

            $point_history = new PointHistory();
            $point_history->auth_user_id = $billingAgreement->user_id;
            $point_history->type = "paypal purchase";
            $point_history->points = 5000;
            $point_history->role = 'client';
            $point_history->save();

            $billingPlan = BillingPlan::find($billingAgreement->billing_plan_id);
            if ($billingPlan && $billingPlan->redirect_url != null)
            {
                return redirect($billingPlan->redirect_url);
            } else {
                return redirect('https://www.paypal.com');
            }


        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this->error(9999);
        }

        //$this->body['data'] = $billingAgreement->toArray();
        //return $this->output($this->body);
  
    }

    public function billingTransactions($agreement_id){

        $billingAgreement = BillingAgreement::find($agreement_id);

        if (!$billingAgreement){
            return $this->error(1004);
        }
        $data_token = JWTAuth::parseToken()->getPayload();
        $auth_id = $data_token->get('id');

        $params = array('start_date' => date('Y-m-d', strtotime('-15 years')), 'end_date' => date('Y-m-d', strtotime('+5 days')));
        $billingPlan = $billingAgreement->billingPlan;
        $paymentId = $billingPlan->payment_id;
        $serviceId = $billingPlan->service_id;

        if($paymentId == $this->_paypalId){
            try {
                $result = Agreement::searchTransactions($billingAgreement->paypal_billing_agreement_id, $params, $this->_apiContext);
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                return $this->error(9999);
            }
            $this->body['data'] = $result->toArray();
        }
        else if($paymentId == $this->_stripeId){
            $customer = Customer::member($auth_id, $this->_stripeId, $serviceId)->first();            
            if(!$customer) {
                return $this->error(1004);
            }
            $result = $this->_spPayment->listCharges(['customer' => $customer->customer_id, 'limit' => 100]);

            if(!$result) return $this->error(9999);
            $this->body['data'] = $result->data;
        }
        else if ($paymentId == $this->_paidjpId){
            $data = Purchase::success($auth_id, $paymentId, $serviceId)->get();
            $this->body['data'] = $data;
        }
        

        
        return $this->output($this->body);
  
    }


    /* PRIVATE FUNCTION  */

    /**
     * add new billing plan into database
     * @param string $serviceId 
     * @param string $planId    
     * @param  int $type The frequency with which a subscription should be billed.
     * @param int $paymentId payment gateway id 1: paypal, 2 : stripe
     * 1: year , 0 : month
     */
    private function setBillingPlan($serviceId, $planId, $type, $paymentId)
    {
        $exist = BillingPlan::where('service_id', $serviceId)->where('paypal_billing_plan_id', $planId)->where('type', $type)->first();
        if($exist) return;
        $amount = $type == self::MONTHLY_TYPE ? 25 : 300;
        $billingPlan = new BillingPlan();
        $billingPlan->service_id = $serviceId;
        $billingPlan->paypal_billing_plan_id = $planId;
        $billingPlan->type = $type;
        $billingPlan->payment_id = $paymentId;
        $billingPlan->amount = $amount;
        $billingPlan->save();
    }

    /**
     * insert new billing agreement into database
     * @param int $billing_plan_id 
     * @param string $token           payment card token
     * @param int $authId          auth user id
     * @param string $customerId      customer id response from stripe
     */
    private function setBillingAgreement($billing_plan_id, $authId, $token = null, $paypal_billing_agreement_id = null)
    {
        $billingAgreement = new BillingAgreement();
        $billingAgreement->billing_plan_id = $billing_plan_id;               
        $billingAgreement->paypal_token = $token;
        $billingAgreement->user_id = $authId;
        $billingAgreement->paypal_billing_agreement_id = $paypal_billing_agreement_id;
        $billingAgreement->status = 1;
        $billingAgreement->save();
        return $billingAgreement;
        # code...
    }
}