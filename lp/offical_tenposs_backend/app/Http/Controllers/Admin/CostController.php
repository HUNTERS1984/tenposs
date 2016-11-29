<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffCat;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Utils\RedisControl;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\ImageRequest;
use Illuminate\Http\JsonResponse;

use App\Models\Users;
use Carbon\Carbon;
use cURL;


define('API_PAYMENT_BASE', 'localhost:8888/api/v1/');

class CostController extends Controller
{
    protected $request;

    protected $api_payment_userplan= API_PAYMENT_BASE.'userplan';
    protected $api_payment_billingplan= API_PAYMENT_BASE.'billingplan';
    protected $api_payment_billingagreement= API_PAYMENT_BASE.'billingagreement';
    protected $api_payment_transaction= API_PAYMENT_BASE.'billingtransactions';

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function index()
    {
        if ($userplan = $this->check_payment()) {
            //dd($userplan->data);
            $response = cURL::newRequest('get', $this->api_payment_transaction."/".$userplan->data->id)
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $transactions = json_decode($response->body);
            $transaction_num = 0;
            foreach ($transactions->data->agreement_transaction_list as $trans) {
                if ($trans->status == "Completed")
                     $transaction_num++;
            }
            $member_months = $transaction_num;

            if ($userplan->data->billingplan->type==1) // yearly plan
                $member_months *= 12;

            return view('admin.pages.cost.index', compact('userplan', 'transactions', 'transaction_num', 'member_months'));
        } else {
            return view('admin.pages.cost.start');
        }
            
    }

    public function register()
    {
        return view('admin.pages.cost.register');
    }

    public function payment($type)
    {
        if ($this->check_payment())
            return redirect()->route('admin.cost.index');

        $response = cURL::newRequest('get', $this->api_payment_billingplan."?type=".$type)
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();

        $billingplans = json_decode($response->body);
        //dd($billingplans);
        if ($billingplans && count($billingplans->data) > 0) {
            $response = cURL::newRequest('post', $this->api_payment_billingagreement."/".$billingplans->data[0]->id)
                 ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $agree = json_decode($response->body);
            //https:\/\/www.sandbox.paypal.com\/cgi-bin\/webscr?cmd=_express-checkout&token=EC-43U043284X871120T
            if ($agree && $agree->data)
            {
                return redirect($agree->data->approveUrl);
            } else {
                return redirect()->back()->withErrors('Payment fail');
            }
        } else {
            return redirect()->back()->withErrors('No billing plan');
        }
       
        
    }

     function check_payment() {
        $response = cURL::newRequest('get', $this->api_payment_userplan )
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();

        $userplan = json_decode($response->body);
            
        if( isset($userplan->code) && $userplan->code == 1000 )
            return $userplan;     
        else {
            return false;
        }
    }
    

}
