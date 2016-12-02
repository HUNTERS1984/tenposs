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
use Illuminate\Support\Facades\Input;
use App\Models\Users;
use Carbon\Carbon;
use cURL;


#define('API_PAYMENT_BASE', 'localhost:8888/api/v1/');
define('API_PAYMENT_BASE', 'https://apipoints.ten-po.com/api/v1/');
define('API_POINT_BASE', 'https://apipoints.ten-po.com/point/');

class CostController extends Controller
{
    protected $request;

    protected $api_payment_userplan= API_PAYMENT_BASE.'userplan';
    protected $api_payment_billingplan= API_PAYMENT_BASE.'billingplan';
    protected $api_payment_billingagreement= API_PAYMENT_BASE.'billingagreement';
    protected $api_payment_transaction= API_PAYMENT_BASE.'billingtransactions';

    protected $api_point_client= API_POINT_BASE.'client';
    protected $api_point_setting= API_POINT_BASE.'setting';
    protected $api_point_payment_method= API_POINT_BASE.'payment/method';

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
            $start_month =  date("Y.m", strtotime($userplan->data->updated_at));
            $end_month =  date("Y.m", strtotime($userplan->data->updated_at. "+ ".$member_months." months"));

            $response = cURL::newRequest('get', $this->api_point_client."?app_id=".$this->request->app->app_app_id)
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $point_info = json_decode($response->body);

            return view('admin.pages.cost.index', compact('userplan', 'transactions', 'transaction_num', 'member_months', 'start_month', 'end_month', 'point_info'));
        } else {
            return view('admin.pages.cost.start');
        }
            
    }

    public function setting()
    {   
        $rules = [
            'yen_to_mile' => 'required',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $response = cURL::newRequest('post', $this->api_point_setting,
                ['app_id' => $this->request->app->app_app_id,
                'yen_to_mile' => Input::get('yen_to_mile'),
                'max_point_use' => Input::get('max_point_use'),
                'bonus_miles_1' => Input::get('bonus_miles_1'),
                'bonus_miles_2' => Input::get('bonus_miles_2'),
                'rank1' => Input::get('rank1'),
                'rank2' => Input::get('rank2'),
                'rank3' => Input::get('rank3'),
                'rank4' => Input::get('rank4'),
                 ])->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $result = json_decode($response->body);
            if ($result && $result->code && $result->code == '1000')
                return redirect()->back()->with('status','Update POM setting successfully');
            else
                return redirect()->back()->withErrors('Cannot update POM setting');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot update POM setting');
        }
    }

    public function payment_method()
    {   
        $rules = [
            'payment_method' => 'required',
        ];
        $v = Validator::make($this->request->all(),$rules);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v);
        }
        try {
            $response = cURL::newRequest('post', $this->api_point_payment_method,
                ['app_id' => $this->request->app->app_app_id,
                'payment_method' => Input::get('payment_method'),
                 ])->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $result = json_decode($response->body);
            if ($result && $result->code && $result->code == '1000')
                return redirect()->back()->with('status','Update POM payment method successfully');
            else
                return redirect()->back()->withErrors('Cannot update POM payment method');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Cannot update POM payment method');
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
            //dd($response);
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
