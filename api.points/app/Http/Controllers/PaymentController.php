<?php
  
namespace App\Http\Controllers;
  
use App\Models\Payment;
use Illuminate\Http\Request;
use Anouar\Paypalpayment\PaypalPayment;
  
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

    public function index(){

        $Payment =  PaypalPayment::getAll(array('count' => 10, 'start_index' => 0), $this->_apiContext);
        
        $this->body['data'] = $Payment->toArray();
        return $this->output($this->body);
        
  
    }
  
    public function getPayment($payment_id){
  
        $Payment = Paypalpayment::getById($payment_id,$this->_apiContext);
        
        $this->body['data'] = $Payment->toArray();
        return $this->output($this->body);
    }
  
    public function createPayment(Request $request){
  
        $addr= Paypalpayment::address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostalCode("14305");
        $addr->setCountryCode("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
            ->setNumber("4758411877817150")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("456")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $item1 = Paypalpayment::item();
        $item1->setName('Monthly free for POINT function')
                ->setDescription('Monthly free for POINT function')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(2.5)
                ->setPrice(25);


        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1));


        $details = Paypalpayment::details();
        $details->setShipping("0")
                ->setTax("2.5")
                //total of items prices
                ->setSubtotal("25");

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("27.5")
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);


        // $paymentId = $payment->id;
        // $PayerID = $payer->id;

        // //dd($payer);
        // $payment = Paypalpayment::getById($paymentId, $this->_apiContext);

        // // PaymentExecution object includes information necessary 
        // // to execute a PayPal account payment. 
        // // The payer_id is added to the request query parameters
        // // when the user is redirected from paypal back to your site
        // $execution = Paypalpayment::PaymentExecution();
        // $execution->setPayerId($PayerID);

        // //Execute the payment
        // $payment->execute($execution,$this->_apiContext);

  
    }
  
    public function deletePayment($id){
        // $Payment  = Payment::find($id);
        // $Payment->delete();
 
        // return response()->json('deleted');
    }
  
    public function updatePayment(Request $request,$id){
        // $Payment  = Payment::find($id);
        // $Payment->title = $request->input('title');
        // $Payment->author = $request->input('author');
        // $Payment->isbn = $request->input('isbn');
        // $Payment->save();
  
        // return response()->json($Payment);
    }
  
}