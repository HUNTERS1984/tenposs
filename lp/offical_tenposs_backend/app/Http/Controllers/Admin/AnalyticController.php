<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Utils\HttpRequestUtil;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


use Illuminate\Support\Facades\Config;
use Session;
use Log;
use DB;

define('REQUEST_NOTIFICATION_ITEMS', 2);

class AnalyticController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function google_analytic()
    {
        return view('admin.pages.analytic.google');

    }

    public function get_data()
    {
        $data_type = $this->request->input('data_type');
        $from_date = $this->request->input('from_date'); //Y-m-d
        $to_date = $this->request->input('to_date'); // //Y-m-d
        $time_type = $this->request->input('time_type'); //M,W,D,Y
        $report_type = $this->request->input('report_type');//'ga:users','ga:sessions','ga:screenviews','ga:bounceRate','ga:avgSessionDuration','ga:percentNewSessions');
        //post,coupon_use,coupon_created
        $returnData = array();

        switch ($data_type) {
            case 'ga_detail':
                $arr_data = array('from_date' => $from_date,
                    'to_date' => $to_date,
                    'time_type' => $time_type,
                    'data_type' => 'detail',
                    'report_type' => $report_type);
                $returnData = HttpRequestUtil::getInstance()->get_data(Config::get('api.url_api_google_analytic'), $arr_data);
                break;
            case 'ga_total_all':
                $arr_data = array('from_date' => $from_date,
                    'to_date' => $to_date,
                    'time_type' => $time_type,
                    'data_type' => 'all');
                $returnData = HttpRequestUtil::getInstance()->get_data(Config::get('api.url_api_google_analytic'), $arr_data);
                break;
            case 'cp_total_all':
                $returnData = array('code' => 1000, 'message' => 'Success',
                    'data' => array(
                        array("report_type" => 'coupon_use',
                            'total' => $this->cp_total_use($from_date, $to_date)),
                        array('report_type' => 'post',
                            'total' => $this->cp_total_post($from_date, $to_date)),
                        array('report_type' => 'coupon_created',
                            'total' => $this->cp_total_coupon($from_date, $to_date))));
                break;
            case 'cp_detail':
                $arr_tmp = array();
                $format_date = '';
                switch ($time_type) {
                    case 'D':
                        $format_date = '%Y%m%d';
                        break;
                    case 'M':
                        $format_date = '%Y%m';
                        break;
                    case 'Y':
                        $format_date = '%Y';
                        break;
                    default:
                        break;
                }
                switch ($report_type) {
                    case 'post':
                        $arr_tmp = $this->cp_detail_post($from_date, $to_date, $format_date);
                        break;
                    case 'coupon_use':
                        $arr_tmp = $this->cp_detail_use($from_date, $to_date, $format_date);
                        break;
                    case 'coupon_created':
                        $arr_tmp = $this->cp_detail_coupon($from_date, $to_date, $format_date);
                        break;
                    default:
                        break;
                }
                $returnData = array('code' => 1000, 'message' => 'Success',
                    'data' => $arr_tmp);
                break;
            default:
                break;
        }
//        $arr = array("label" => ["January", "February", "March", "April", "May", "June", "July"],
//            "data" => [65, 59, 80, 81, 56, 55, 40]);
//        return \Illuminate\Support\Facades\Response::json($returnData);
        return $returnData;
    }

    public function coupon_analytic()
    {
        return view('admin.pages.analytic.coupon');
    }

    public function store_analytic()
    {
        return view('admin.pages.analytic.store');
    }

    private function cp_total_use($from_date, $to_date)
    {
//        $ls_app_user_id = App::where('user_id', \Illuminate\Support\Facades\Session::get('user')->id)
//            ->with('app_users')->get()->toArray();
//        echo '<pre>';
        $total_use = 0;
        try {
            $total_use = \Illuminate\Support\Facades\DB::table('apps')
                ->join('app_users', 'apps.id', '=', 'app_users.app_id')
                ->join('rel_app_users_coupons', 'app_users.id', '=', 'rel_app_users_coupons.app_user_id')
                ->whereNotNull('rel_app_users_coupons.user_use_date')
                ->where('apps.user_id', '=', \Illuminate\Support\Facades\Session::get('user')->id)
                ->whereBetween('rel_app_users_coupons.user_use_date',
                    array(new \DateTime($from_date), new \DateTime($to_date)))
//            ->groupBy('rel_app_users_coupons.app_user_id')
                ->distinct('rel_app_users_coupons.app_user_id')->count('rel_app_users_coupons.app_user_id');
        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return $total_use;
    }

    private function cp_total_post($from_date, $to_date)
    {
        $total_post = 0;
        try {
            $total_post = \Illuminate\Support\Facades\DB::table('apps')
                ->join('app_users', 'apps.id', '=', 'app_users.app_id')
                ->join('posts', 'app_users.id', '=', 'posts.app_user_id')
                ->where('apps.user_id', '=', \Illuminate\Support\Facades\Session::get('user')->id)
                ->whereBetween('posts.created_at',
                    array(new \DateTime($from_date), new \DateTime($to_date)))
                ->count('posts.id');
        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return $total_post;
    }

    private function cp_total_coupon($from_date, $to_date)
    {
        $total_coupon = 0;
        try {
            $total_coupon = \Illuminate\Support\Facades\DB::table('apps')
                ->join('stores', 'apps.id', '=', 'stores.app_id')
                ->join('coupon_types', 'stores.id', '=', 'coupon_types.store_id')
                ->join('coupons', 'coupon_types.id', '=', 'coupons.coupon_type_id')
                ->where('apps.user_id', '=', \Illuminate\Support\Facades\Session::get('user')->id)
                ->whereBetween('coupons.created_at',
                    array(new \DateTime($from_date), new \DateTime($to_date)))
                ->count('coupons.id');
        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return $total_coupon;
    }


    private function cp_detail_use($from_date, $to_date,$format_date)
    {
        $detail_use = null;
        try {
            $detail_use = \Illuminate\Support\Facades\DB::table('apps')
                ->join('app_users', 'apps.id', '=', 'app_users.app_id')
                ->join('rel_app_users_coupons', 'app_users.id', '=', 'rel_app_users_coupons.app_user_id')
                ->whereNotNull('rel_app_users_coupons.user_use_date')
                ->where('apps.user_id', '=', \Illuminate\Support\Facades\Session::get('user')->id)
                ->whereBetween('rel_app_users_coupons.user_use_date',
                    array(new \DateTime($from_date), new \DateTime($to_date)))
                ->groupBy(DB::raw('DATE_FORMAT(rel_app_users_coupons.user_use_date, \''.$format_date.'\')'))
                ->select(DB::raw('DATE_FORMAT(rel_app_users_coupons.user_use_date, \''.$format_date.'\') as DateId'),
                    DB::raw('count(DISTINCT rel_app_users_coupons.app_user_id) as total'))
                ->get();
        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return $this->parse_data_to_report($detail_use, "Coupon Use");
    }

    private function cp_detail_post($from_date, $to_date, $format_date)
    {
        $total_post = null;
        try {
            $total_post = \Illuminate\Support\Facades\DB::table('apps')
                ->join('app_users', 'apps.id', '=', 'app_users.app_id')
                ->join('posts', 'app_users.id', '=', 'posts.app_user_id')
                ->where('apps.user_id', '=', \Illuminate\Support\Facades\Session::get('user')->id)
                ->whereBetween('posts.created_at',
                    array(new \DateTime($from_date), new \DateTime($to_date)))
                ->groupBy(DB::raw('DATE_FORMAT(posts.created_at, \''.$format_date.'\')'))
                ->select(DB::raw('DATE_FORMAT(posts.created_at, \''.$format_date.'\') as DateId'),
                    DB::raw('count(posts.id) as total'))
                ->get();
        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return $this->parse_data_to_report($total_post, "Post");
    }

    private function cp_detail_coupon($from_date, $to_date,$format_date)
    {
        $detail_coupon = null;
        try {
            $detail_coupon = \Illuminate\Support\Facades\DB::table('apps')
                ->join('stores', 'apps.id', '=', 'stores.app_id')
                ->join('coupon_types', 'stores.id', '=', 'coupon_types.store_id')
                ->join('coupons', 'coupon_types.id', '=', 'coupons.coupon_type_id')
                ->where('apps.user_id', '=', \Illuminate\Support\Facades\Session::get('user')->id)
                ->whereBetween('coupons.created_at',
                    array(new \DateTime($from_date), new \DateTime($to_date)))
                ->groupBy(DB::raw('DATE_FORMAT(coupons.created_at, \''.$format_date.'\')'))
                ->select(DB::raw('DATE_FORMAT(coupons.created_at, \''.$format_date.'\') as DateId'),
                    DB::raw('count(coupons.id) as total'))
                ->get();
        } catch (QueryException $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
        }
        return $this->parse_data_to_report($detail_coupon, "Coupon Created");
    }

    private function parse_data_to_report($arr_input, $report_name)
    {
        if (count($arr_input) > 0) {
            $arr_label = array();
            $arr_data = array();
            foreach ($arr_input as $item) {
                $arr_label[] = $item->DateId;
                $arr_data[] = $item->total;
            }
            return array('label' => $arr_label, 'data_chart' => $arr_data, 'name' => $report_name);
        }
        return null;
    }
}
