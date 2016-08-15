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

class ItemController extends Controller
{
    public function menu(Request $request) {

        $check_items = array('store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            $app = Menu::where('store_id', Input::get('store_id'))->select(['id', 'name'])->get()->toArray();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['menus'] = $app;
        return $this->output($this->body);
    }

    public function items(Request $request) {

        $check_items = array('menu_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);

        $skip = (Input::get('pageindex') - 1)*Input::get('pagesize');
        try {
            $total_items = Menu::find(Input::get('menu_id'))->items()->count();
            $items = [];
            if ($total_items > 0)
                $items = Menu::find(Input::get('menu_id'))->items()->skip($skip)->take(Input::get('pagesize'))->with('rel_items')->get()->toArray();

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['items'] = $items;
        $this->body['data']['total_items'] = $total_items;
        return $this->output($this->body);
    }
}
