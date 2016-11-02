<?php
  
namespace App\Http\Controllers;
  
use App\Models\Payment;
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

    // public function index(){

    //     $Payment =  PaypalPayment::getAll(array('count' => 10, 'start_index' => 0), $this->_apiContext);
        
    //     $this->body['data'] = $Payment->toArray();
    //     return $this->output($this->body);
        
  
    // }
  
    // public function getPayment($payment_id){
  
    //     $Payment = Paypalpayment::getById($payment_id,$this->_apiContext);
        
    //     $this->body['data'] = $Payment->toArray();
    //     return $this->output($this->body);
    // }
  
    // public function createPayment(Request $request){
  
    //     $addr= Paypalpayment::address();
    //     $addr->setLine1("3909 Witmer Road");
    //     $addr->setLine2("Niagara Falls");
    //     $addr->setCity("Niagara Falls");
    //     $addr->setState("NY");
    //     $addr->setPostalCode("14305");
    //     $addr->setCountryCode("US");
    //     $addr->setPhone("716-298-1822");

    //     // ### CreditCard
    //     $card = Paypalpayment::creditCard();
    //     $card->setType("visa")
    //         ->setNumber("4758411877817150")
    //         ->setExpireMonth("05")
    //         ->setExpireYear("2019")
    //         ->setCvv2("456")
    //         ->setFirstName("Joe")
    //         ->setLastName("Shopper");

    //     // ### FundingInstrument
    //     // A resource representing a Payer's funding instrument.
    //     // Use a Payer ID (A unique identifier of the payer generated
    //     // and provided by the facilitator. This is required when
    //     // creating or using a tokenized funding instrument)
    //     // and the `CreditCardDetails`
    //     $fi = Paypalpayment::fundingInstrument();
    //     $fi->setCreditCard($card);

    //     // ### Payer
    //     // A resource representing a Payer that funds a payment
    //     // Use the List of `FundingInstrument` and the Payment Method
    //     // as 'credit_card'
    //     $payer = Paypalpayment::payer();
    //     $payer->setPaymentMethod("credit_card")
    //         ->setFundingInstruments(array($fi));

    //     $item1 = Paypalpayment::item();
    //     $item1->setName('Monthly free for POINT function')
    //             ->setDescription('Monthly free for POINT function')
    //             ->setCurrency('USD')
    //             ->setQuantity(1)
    //             ->setTax(2.5)
    //             ->setPrice(25);


    //     $itemList = Paypalpayment::itemList();
    //     $itemList->setItems(array($item1));


    //     $details = Paypalpayment::details();
    //     $details->setShipping("0")
    //             ->setTax("2.5")
    //             //total of items prices
    //             ->setSubtotal("25");

    //     //Payment Amount
    //     $amount = Paypalpayment::amount();
    //     $amount->setCurrency("USD")
    //             // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
    //             ->setTotal("27.5")
    //             ->setDetails($details);

    //     // ### Transaction
    //     // A transaction defines the contract of a
    //     // payment - what is the payment for and who
    //     // is fulfilling it. Transaction is created with
    //     // a `Payee` and `Amount` types

    //     $transaction = Paypalpayment::transaction();
    //     $transaction->setAmount($amount)
    //         ->setItemList($itemList)
    //         ->setDescription("Payment description")
    //         ->setInvoiceNumber(uniqid());

    //     // ### Payment
    //     // A Payment Resource; create one using
    //     // the above types and intent as 'sale'

    //     $payment = Paypalpayment::payment();

    //     $payment->setIntent("sale")
    //         ->setPayer($payer)
    //         ->setTransactions(array($transaction));

    //     try {
    //         // ### Create Payment
    //         // Create a payment by posting to the APIService
    //         // using a valid ApiContext
    //         // The return object contains the status;
    //         $payment->create($this->_apiContext);
    //     } catch (\PPConnectionException $ex) {
    //         return  "Exception: " . $ex->getMessage() . PHP_EOL;
    //         exit(1);
    //     }

    //     dd($payment);


    //     // $paymentId = $payment->id;
    //     // $PayerID = $payer->id;

    //     // //dd($payer);
    //     // $payment = Paypalpayment::getById($paymentId, $this->_apiContext);

    //     // // PaymentExecution object includes information necessary 
    //     // // to execute a PayPal account payment. 
    //     // // The payer_id is added to the request query parameters
    //     // // when the user is redirected from paypal back to your site
    //     // $execution = Paypalpayment::PaymentExecution();
    //     // $execution->setPayerId($PayerID);

    //     // //Execute the payment
    //     // $payment->execute($execution,$this->_apiContext);

  
    // }

    public function createBillingPlan(Request $request){
  
        $plan = new Plan();
        $plan->setName('Point Service Month Plan')
        ->setDescription('Point Service Month Plan')
        ->setType('fixed');
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 50, 'currency' => 'USD')));
       
        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));

        $paymentDefinition->setChargeModels(array($chargeModel));

        $merchantPreferences = new MerchantPreferences();
        $baseUrl = url();

        $merchantPreferences->setReturnUrl("$baseUrl/api/v1/excecuteagreement?success=true")
        ->setCancelUrl("$baseUrl/api/v1/excecuteagreement?success=false")
        ->setAutoBillAmount("yes")
        ->setInitialFailAmountAction("CONTINUE")
        ->setMaxFailAttempts("0")
        ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));


        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        $request = clone $plan;
        try {
            $output = $plan->create($this->_apiContext);
        } catch (Exception $ex) {
            dd('error');
            exit(1);
        }
       
        $this->body['data'] = $output->toArray();
        return $this->output($this->body);
    }

    public function billingPlan(){
        try {
            $params = array('page_size' => '10');
            $planList = Plan::all($params, $this->_apiContext);
            $this->body['data'] = $planList->toArray();
            return $this->output($this->body);
        } catch (Exception $ex) {
            return $this->error(9999);
        }
    }
    
    public function getBillingPlan($id){
        try {
            $plan = Plan::get($id, $this->_apiContext);
            $this->body['data'] = $plan->toArray();
            return $this->output($this->body);
        } catch (Exception $ex) {
            return $this->error(9999);
        }
    }

    public function updateBillingPlan($id){
        try {
            $plan = Plan::get($id, $this->_apiContext);

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
  
        $agreement = new Agreement();

        $agreement->setName('Base Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate('2019-06-17T9:45:04Z');
        
        $createdPlan = Plan::get($plan_id, $this->_apiContext);


        $plan = new Plan();
        $plan->setId($createdPlan->getId());
        $agreement->setPlan($plan);
        //Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);
        //Add Shipping Address
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        $agreement->setShippingAddress($shippingAddress);
        
        $request = clone $agreement;
       
        try {
            $agreement = $agreement->create($this->_apiContext);
            $approvalUrl = $agreement->getApprovalLink();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            dd($ex);
            return $this->error(9999);
        }

        $this->body['data'] = $agreement->toArray();
        return $this->output($this->body);
  
    }

    public function excecuteAgreement(){
        $agreement = new Agreement();

        $token = $_GET['token'];
        $agreement = new \PayPal\Api\Agreement();
        try {
            // ## Execute Agreement
            // Execute the agreement by passing in the token
            $agreement->execute($token, $this->_apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            dd($ex);
            return $this->error(9999);
        }

        try {
            $agreement = Agreement::get($agreement->getId(), $this->_apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            dd($ex);
            return $this->error(9999);
        }

        $this->body['data'] = $agreement->toArray();
        return $this->output($this->body);
  
    }

    public function billingTransactions($agreement_id){

        $params = array('start_date' => date('Y-m-d', strtotime('-15 years')), 'end_date' => date('Y-m-d', strtotime('+5 days')));

        try {
            $result = Agreement::searchTransactions($agreement_id, $params, $this->_apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            dd($ex);
            return $this->error(9999);
        }

        $this->body['data'] = $result->toArray();
        return $this->output($this->body);
  
    }

}