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



class CostController extends Controller
{
    protected $request;

    protected $api_payment_userplan= 'localhost:8888/api/v1/userplan';

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function index()
    {
        $response = cURL::newRequest('get', $this->api_payment_userplan )
                ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();

        $userplan = json_decode($response->body);
            
        if( isset($userplan->code) && $userplan->code == 1000 )
            return view('admin.pages.cost.index');
        else
            return view('admin.pages.cost.register');
    }

    public function register()
    {
        return view('admin.pages.cost.register');
    }

    public function payment()
    {
        
    }
    

}
