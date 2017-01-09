<?php 
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\BillingAgreement;
use Carbon\Carbon;
use App\Models\Customer;
use App\Classes\Payment\Paid_Payment;
use App\Models\Purchase;
use Log;
class PaidJpCheckout extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'paidjp:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Automatic checkout in paid jp payment gateway each month";

    private $_paidjpId;

    private $_paidPayment;

    private $_purchase;

    public function __construct(Paid_Payment $paidPayment, Purchase $purchase){
        parent::__construct();
        $payment_common = config('payment_common');
        $this->_paidjpId = $payment_common['PAYMENT_ID']['PAIDJP'];
        $this->_paidPayment = $paidPayment;
        $this->_purchase = $purchase;

    }
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $paymentId = $this->_paidjpId;
        $billingAgreements = BillingAgreement::where('status', 1)->whereHas('billingPlan', function ($q) use($paymentId)
        {
            $q->where('payment_id', $paymentId);
        })->get();
        $now = Carbon::now();
        $customers = collect([]);
        foreach ($billingAgreements as $key => $billAgr) {             
            $billingPlan = $billAgr->billingPlan;
            $type = $billingPlan->type;

            if($type == 1) continue;
            $amount = $billingPlan->amount;
            $userId = $billAgr->user_id;
            $serviceId = $billingPlan->service_id;

            $result = $this->_paidPayment->creditNewPurchase($userId, $paymentId, $billingPlan);
            Log::info('paid jp payment', [
                'userId' => $userId,
                'paymentId' => $paymentId,
                'result' => $result
            ]);
        }
        
    }
}