<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\UserSession;
use App\Models\AppUser;
use App\Models\App;
use App\Models\AppSetting;
use App\Models\Store;
use App\Models\Menu;
use App\Models\News;
use App\Models\Item;
use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\Reserve;
use App\Models\UserProfile;
use App\Models\UserPush;
use Mail;
use App\Address;
use Illuminate\Support\Facades\Hash;
use DB;
use Mockery\CountValidator\Exception;

class ReserveController extends Controller
{
    public function index(Request $request) {

        $check_items = array('store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        
        try {
            $reserve = Reserve::find(Input::get('store_id'));

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['reserve'] = $reserve;
        return $this->output($this->body);
    }
}
