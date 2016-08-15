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

class PhotoController extends Controller
{
    public function photo_cat(Request $request) {

        $check_items = array('store_id', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        try {
            $app = PhotoCat::where('store_id', Input::get('store_id'))->select(['id', 'name'])->get()->toArray();
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['photo_categories'] = $app;
        return $this->output($this->body);
    }

    public function index(Request $request) {
        
        $check_items = array('category_id', 'pageindex', 'pagesize', 'time', 'sig');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;

        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);

        $skip = (Input::get('pageindex') - 1)*Input::get('pagesize');
        try {
            $total_photos = Photo::where('photo_category_id', Input::get('category_id'))->count();
            $photos = [];
            if ($total_photos > 0)
                $photos = Photo::where('photo_category_id', Input::get('category_id'))->skip($skip)->take(Input::get('pagesize'))->get()->toArray();

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->error(9999);
        }
    
        $this->body['data']['photos'] = $photos;
        $this->body['data']['total_photos'] = $total_photos;
        return $this->output($this->body);
    }
    
}
