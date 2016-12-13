<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponType;
use App\Models\Staff;
use App\Repositories\Contracts\TopsRepositoryInterface;
use App\Utils\HttpRequestUtil;
use App\Utils\RedisUtil;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Utils\UrlHelper;

use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Config;
use App\Models\UserSession;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    //
    //
    protected $request;
    protected $_topRepository;

    public function __construct(TopsRepositoryInterface $ur, Request $request)
    {
        $this->_topRepository = $ur;
        $this->request = $request;
    }

    //
    public function index()
    {
        $check_items = array('app_id', 'time', 'store_id', 'pageindex', 'pagesize', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_coupon');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        if (Input::get('pageindex') < 1 || Input::get('pagesize') < 1)
            return $this->error(1004);

        $skip = (Input::get('pageindex') - 1) * Input::get('pagesize');
        $token = Input::get('token') ? Input::get('token') : '';
        //create key redis
        $key = sprintf(Config::get('api.cache_coupons'), Input::get('app_id'), Input::get('store_id'), $token, Input::get('pageindex'), Input::get('pagesize'));
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $coupons = [];
            if (Input::get('store_id') == 0) {
                $total_coupon = Coupon::count();
                if ($total_coupon > 0) {
                    $coupons = Coupon::skip($skip)->take(Input::get('pagesize'))->get()->toArray();
//                    for ($i = 0; $i < count($coupons); $i++) {
//                        $coupons[$i]['code'] = '';
//                    }
                }
            } else {
                $list_coupon_type = CouponType::where('store_id', '=', Input::get('store_id'))->whereNull('deleted_at')->get();

                $total_coupon = Coupon::whereIn('coupon_type_id', $list_coupon_type->pluck('id')->toArray())->orderBy('updated_at', 'desc')->count();

                if ($total_coupon > 0) {
                    $currentDate = date('Y-m-d');
                    $currentDate = date('Y-m-d', strtotime($currentDate));

                    $coupons = Coupon::whereIn('coupon_type_id', $list_coupon_type->pluck('id')->toArray())->whereNull('deleted_at')->with('coupon_type')->orderBy('updated_at', 'desc')->skip($skip)->take(Input::get('pagesize'))->get();
                    for ($i = 0; $i < count($coupons); $i++) {
                        $dateBegin = date('Y-m-d', strtotime($coupons[$i]['start_date']));
                        $dateEnd = date('Y-m-d', strtotime($coupons[$i]['end_date']));

                        $coupons[$i]['taglist'] = Coupon::find($coupons[$i]->id)->tags()->lists('tag')->toArray();
                        if (Input::get('token')) { // in case login
                            $session = UserSession::where('token', Input::get('token'))->first();

                            if ($session) {
                                $user = $session->app_user()->first();
                                $coupons[$i]['can_use'] = DB::table('rel_app_users_coupons')
                                        ->whereAppUserId($user->id)
                                        ->whereCouponId($coupons[$i]->id)
                                        ->count() > 0 & $dateBegin <= $currentDate & $dateEnd >= $currentDate;
                                $coupon_code = DB::table('rel_app_users_coupons')
                                    ->whereAppUserId($user->id)
                                    ->whereCouponId($coupons[$i]->id)
                                    ->where('status', 1)->get();
                                if (count($coupon_code) > 0) {
                                    $coupons[$i]['code'] = $coupon_code[0]->code;
                                    $coupons[$i]['url_scan_qr'] = sprintf(Config::get('api.url_open_coupon_code'), $user->id, $coupons[$i]->id, $coupon_code[0]->code, hash("sha256", $user->id . $coupons[$i]->id . $coupon_code[0]->code . '-' . Config::get('api.secret_key_coupon_use')));

                                } else {
                                    $coupons[$i]['code'] = '';
                                    $coupons[$i]['url_scan_qr'] = '';
                                }
                            } else {
                                $coupons[$i]['can_use'] = false;
                                $coupons[$i]['code'] = '';
                                $coupons[$i]['url_scan_qr'] = '';
                            }

                        } else {
                            $coupons[$i]['can_use'] = false;
                            $coupons[$i]['code'] = '';
                            $coupons[$i]['url_scan_qr'] = '';
                        }
                        $coupons[$i]['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $coupons[$i]['image_url']);

                    }

                }

            }
        } catch (QueryException $e) {
            return $this->error(9999);
        }
        $this->body['data']['coupons'] = $coupons;
        $this->body['data']['total_coupons'] = $total_coupon;
        if ($total_coupon > 0) { // set cache reiis
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);

    }

    public function coupon_detail()
    {
        $check_items = array('app_id', 'time', 'id', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_coupon_detail');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        //create key redis
        $token = Input::get('token') ? Input::get('token') : '';
        $key = sprintf(Config::get('api.cache_coupons_detail'), Input::get('app_id'), Input::get('id'), $token);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $currentDate = date('Y-m-d');
            $currentDate = date('Y-m-d', strtotime($currentDate));

            $coupons = Coupon::where('id', Input::get('id'))->with('coupon_type')->first();

            if (count($coupons) > 0) {
                $dateBegin = date('Y-m-d', strtotime($coupons['start_date']));
                $dateEnd = date('Y-m-d', strtotime($coupons['end_date']));

                $coupons['taglist'] = Coupon::find(Input::get('id'))->tags()->lists('tag')->toArray();

                if (Input::get('token')) { // in case login
                    if ($this->request->token_info['id'] > 0) {
                        $coupons['can_use'] = DB::table('rel_app_users_coupons')
                                ->whereAppUserId($this->request->token_info['id'])
                                ->whereCouponId($coupons['id'])
                                ->count() > 0 & $dateBegin <= $currentDate & $dateEnd >= $currentDate;
                        $coupon_code = DB::table('rel_app_users_coupons')
                            ->whereAppUserId($this->request->token_info['id'])
                            ->whereCouponId($coupons['id'])
                            ->where('status', 1)->get();
                        if (count($coupon_code) > 0) {
                            $coupons['code'] = $coupon_code[0]->code;
                            $coupons['url_scan_qr'] = sprintf(Config::get('api.url_open_coupon_code'), $user->id, $coupons['id'], $coupon_code[0]->code, hash("sha256", $user->id . $coupons['id'] . $coupon_code[0]->code . '-' . Config::get('api.secret_key_coupon_use')));
                        } else {
                            $coupons['code'] = '';
                            $coupons['url_scan_qr'] = '';
                        }
                    } else {
                        $coupons['can_use'] = false;
                        $coupons['code'] = '';
                        $coupons['url_scan_qr'] = '';
                    }

                } else {
                    $coupons['can_use'] = false;
                    $coupons['code'] = '';
                    $coupons['url_scan_qr'] = '';
                }
                $coupons['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $coupons['image_url']);

            }

        } catch (QueryException $e) {
            return $this->error(9999);
        }
        $this->body['data']['coupons'] = $coupons;
        if (count($coupons) > 0) { // set cache reiis
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);

    }

    public function v2_coupon_detail()
    {
        $check_items = array('app_id', 'time', 'id', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_coupon_detail');
        // check app_id in database
        $app = $this->_topRepository->get_app_info_array(Input::get('app_id'));
        if ($app == null || count($app) == 0)
            return $this->error(1004);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        //create key redis
        $token = Input::get('token') ? Input::get('token') : '';
        $key = sprintf(Config::get('api.cache_coupons_detail'), Input::get('app_id'), Input::get('id'), $token);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $coupons = Coupon::where('id', Input::get('id'))->with('coupon_type')->first();
            if (count($coupons) > 0) {
                $coupons['taglist'] = Coupon::find(Input::get('id'))->tags()->lists('tag')->toArray();
                $coupons['can_use'] = false;
                $coupons['code'] = '';
                $coupons['url_scan_qr'] = '';
            }
            $coupons['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $coupons['image_url']);
        } catch (QueryException $e) {
            return $this->error(9999);
        }
        $this->body['data']['coupons'] = $coupons;
        if (count($coupons) > 0) { // set cache reiis
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);

    }

    public function v2_coupon_detail_login()
    {
        $check_items = array('app_id', 'id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $app_info = $this->_topRepository->get_app_id_and_app_user_id(Input::get('app_id'), $this->request->token_info['id']);
        if (count($app_info) < 1)
            return $this->error(1004);
        //create key redis
        $key = sprintf(Config::get('api.cache_coupons_detail'), Input::get('app_id'), Input::get('id'), $app_info['app_user_id']);
        //get data from redis
        $data = RedisUtil::getInstance()->get_cache($key);
//        $data = null;
        //check data and return data
        if ($data != null) {
            $this->body = $data;
            return $this->output($this->body);
        }
        try {
            $currentDate = date('Y-m-d');
            $currentDate = date('Y-m-d', strtotime($currentDate));

            $coupons = Coupon::where('id', Input::get('id'))->with('coupon_type')->first();

            if (count($coupons) > 0) {
                $dateBegin = date('Y-m-d', strtotime($coupons['start_date']));
                $dateEnd = date('Y-m-d', strtotime($coupons['end_date']));

                $coupons['taglist'] = Coupon::find(Input::get('id'))->tags()->lists('tag')->toArray();

                if ($app_info['app_user_id'] > 0) { // in case login
                    $coupons['can_use'] = DB::table('rel_app_users_coupons')
                            ->whereAppUserId($app_info['app_user_id'])
                            ->whereCouponId($coupons['id'])
                            ->count() > 0 & $dateBegin <= $currentDate & $dateEnd >= $currentDate;
                    $coupon_code = DB::table('rel_app_users_coupons')
                        ->whereAppUserId($app_info['app_user_id'])
                        ->whereCouponId($coupons['id'])
                        ->where('status', 1)->get();
                    if (count($coupon_code) > 0) {
                        $coupons['code'] = $coupon_code[0]->code;
                        $coupons['url_scan_qr'] = sprintf(Config::get('api.url_open_coupon_code'), $app_info['app_user_id'], $coupons['id'], $coupon_code[0]->code, hash("sha256", $app_info['app_user_id'] . $coupons['id'] . $coupon_code[0]->code . '-' . Config::get('api.secret_key_coupon_use')));
                    } else {
                        $coupons['code'] = '';
                        $coupons['url_scan_qr'] = '';
                    }
                } else {
                    $coupons['can_use'] = false;
                    $coupons['code'] = '';
                    $coupons['url_scan_qr'] = '';
                }
                $coupons['image_url'] = UrlHelper::convertRelativeToAbsoluteURL(Config::get('api.media_base_url'), $coupons['image_url']);
            }
        } catch (QueryException $e) {
            return $this->error(9999);
        }
        $this->body['data']['coupons'] = $coupons;
        if (count($coupons) > 0) { // set cache reiis
            RedisUtil::getInstance()->set_cache($key, $this->body);
        }
        return $this->output($this->body);

    }

    public function coupon_use()
    {
        $check_items = array('token', 'time', 'app_user_id', 'coupon_id', 'staff_id', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_coupon_use');
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));

        if (!$app)
            return $this->error(9998);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        try {
            $coupon = DB::table('rel_app_users_coupons')
                ->whereAppUserId(Input::get('app_user_id'))
                ->whereCouponId(Input::get('coupon_id'))->update(
                    ['status' => 2,
                        'staff_id' => Input::get('staff_id'),
                        'user_use_date' => Carbon::now()]);
            if ($coupon == 0)
                return $this->error(1014);

        } catch (QueryException $e) {
            print_r($e->getMessage());
            die;
            return $this->error(9999);
        }
        return $this->output($this->body);

    }

    public function v2_coupon_use()
    {
        $check_items = array('app_id', 'app_user_id', 'coupon_id', 'staff_id');

        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $app_info = $this->_topRepository->get_app_id_and_app_user_id(Input::get('app_id'), $this->request->token_info['id']);

        if (count($app_info) < 1)
            return $this->error(1004);
        if ($app_info['app_user_id'] != Input::get("app_user_id"))
            return $this->error(1004);
        try {
            $check_exist = DB::table('rel_app_users_coupons')
                ->whereAppUserId(Input::get('app_user_id'))
                ->whereStatus(1)
                ->whereCouponId(Input::get('coupon_id'))->get();
            if (count($check_exist) > 0) {
                try {
//            DB::enableQueryLog();
                    DB::beginTransaction();
                    $coupon = DB::table('rel_app_users_coupons')
                        ->whereAppUserId(Input::get('app_user_id'))
                        ->whereStatus(1)
                        ->whereCouponId(Input::get('coupon_id'))->update(
                            ['status' => 2,
                                'staff_id' => Input::get('staff_id'),
                                'user_use_date' => Carbon::now()]);
//            print_r(DB::getQueryLog());
//            die;
                    if ($coupon == 0)
                        return $this->error(1014);
                    //call notification to staff
                    $isCall = $this->call_notification_to_staff(Input::get('app_id'), Input::get('coupon_id'), Input::get('app_user_id'), Input::get('staff_id'), $check_exist[0]->code, $this->request->token);
                    if (!$isCall) {
                        DB::rollBack();
                        return $this->error(1021);
                    }
                    DB::commit();
                } catch (QueryException $e) {
                    Log::error($e->getMessage());
                    DB::rollBack();
                    return $this->error(9999);
                }
            } else
                return $this->error(1014);
        } catch (QueryException $e) {
            Log::error($e->getMessage());;
            return $this->error(9999);
        }
        return $this->output($this->body);

    }

    public function coupon_use_new()
    {
        $check_items = array('token', 'time', 'code', 'staff_id', 'sig');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        //start validate app_id and sig
        $check_sig_items = Config::get('api.sig_coupon_use');
        $app = $this->_topRepository->get_app_info_from_token(Input::get('token'));

        if (!$app)
            return $this->error(9998);
        //validate sig
        $ret_sig = $this->validate_sig($check_sig_items, $app['app_app_secret']);
        if ($ret_sig)
            return $ret_sig;
        //end validate app_id and sig
        try {
            $coupon = DB::table('rel_app_users_coupons')
                ->whereCode(Input::get('code'))->update(
                    ['status' => 2,
                        'staff_id' => Input::get('staff_id'),
                        'user_use_date' => Carbon::now()]);
            if ($coupon == 0)
                return $this->error(1014);

        } catch (QueryException $e) {
            print_r($e->getMessage());
            die;
            return $this->error(9999);
        }
        return $this->output($this->body);

    }

    public function v2_coupon_use_new()
    {
        $check_items = array('app_id', 'code', 'staff_id');
        $ret = $this->validate_param($check_items);
        if ($ret)
            return $ret;
        $app_info = $this->_topRepository->get_app_id_and_app_user_id(Input::get('app_id'), $this->request->token_info['id']);
        if (count($app_info) < 1)
            return $this->error(1004);
        try {
            $check_exist = DB::table('rel_app_users_coupons')
                ->whereStatus(1)
                ->whereCode(Input::get('code'))->get();
            if (count($check_exist) > 0) {
                try {

                    DB::beginTransaction();
                    $coupon = DB::table('rel_app_users_coupons')
                        ->whereStatus(1)
                        ->whereCode(Input::get('code'))->update(
                            ['status' => 2,
                                'staff_id' => Input::get('staff_id'),
                                'user_use_date' => Carbon::now()]);
                    if ($coupon == 0)
                        return $this->error(1014);
                    //call notification to staff
                    $isCall = $this->call_notification_to_staff(Input::get('app_id'), $check_exist[0]->coupon_id, $check_exist[0]->app_user_id, Input::get('staff_id'), Input::get('code'), $this->request->token);
                    if (!$isCall) {
                        DB::rollBack();
                        return $this->error(1021);
                    }
                    DB::commit();
                } catch (QueryException $e) {
                    Log::error($e->getMessage());
                    DB::rollBack();
                    return $this->error(9999);
                }
            } else
                return $this->error(1014);
        } catch (QueryException $e) {
            Log::error($e->getMessage());;
            return $this->error(9999);
        }
        return $this->output($this->body);

    }

    private function call_notification_to_staff($app_app_id, $coupon_id, $app_user_id, $staff_id, $code, $token)
    {
        $type = 'coupon_use';
        $staffs = array();
        try {
            $staffs = Staff::find($staff_id);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }
        if (count($staffs) > 0) {
            return HttpRequestUtil::getInstance()->post_data_with_token_return_boolean(
                Config::get('api.url_staff_notification'),
                ['app_id' => $app_app_id,
                    'type' => $type,
                    'notification_to' => $staffs->auth_user_id,
                    'staff_id' => $staff_id,
                    'code' => $code,
                    'coupon_id' => $coupon_id,
                    'app_user_id' => $app_user_id],
                $token
            );
        }
    }
}
