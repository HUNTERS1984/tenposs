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

use App\Models\Users;
use Carbon\Carbon;
use cURL;



class CostController extends Controller
{
    protected $request;

    protected $api_regiser_billingplan= 'https://auth.ten-po.com/v1/profile';

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function index()
    {
        return view('admin.pages.cost.index');
    }

    public function register()
    {
        return view('admin.pages.cost.register');
    }

    public function payment()
    {
        
    }
    

}
