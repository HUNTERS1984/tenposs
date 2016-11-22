<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
        $type_data = $this->request->input('type_data');
        $from_date = $this->request->input(' '); //Y-m-d
        $to_date = $this->request->input('to_date'); // //Y-m-d
        $time_type = $this->request->input('time_type'); //M,W,D,Y
        $returnData = array();

        switch ($type_data) {
            case 'ga':
                $returnData = $this->getDataFromGoogleAnalytics($from_date, $to_date);
                break;
            default:
                break;
        }
        $arr = array("label" => ["January", "February", "March", "April", "May", "June", "July"],
            "data" => [65, 59, 80, 81, 56, 55, 40]);
        return \Illuminate\Support\Facades\Response::json($arr);
    }

    private function getDataFromGoogleAnalytics($from_date, $to_date)
    {
        $arrLabel = array();
        $arrData = array();
        $analytics = $this->ga_init();
        $profileName = '';
        $profileId = $this->ga_get_profile($analytics);
//        $from = date('Y-m-d', time() - 2 * 24 * 60 * 60); // 2 days
//        $to = date('Y-m-d'); // today
//        $dimensions = 'ga:date,ga:year,ga:month,ga:week,ga:day';
        $dimensions = 'ga:date';
        $results = $analytics->data_ga->get(
            'ga:' . $profileId,
            $from_date,
            $to_date,
            'ga:pageviews', array('dimensions' => $dimensions));
        if ($results != null) {
            if (count($results->getRows()) > 0) {

                // Get the profile name.
                $profileName = $results->getProfileInfo()->getProfileName();

                // Get the entry for the first entry in the first row.
                $rows = $results->getRows();
                for ($i = 0; $i < count($rows); $i++) {
                    $arrLabel[] = $rows[$i][0];
                    $arrData[] = $rows[$i][1];
                }
            }
        }
        if (count($arrData) > 0) {
            return array('label' => $arrLabel, 'data' => $arrData, 'name' => $profileName);
        }
        return null;
    }

    private function ga_get_profile($analytics)
    {
        // Get the user's first view (profile) ID.

        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                    ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();

                } else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            } else {
                throw new Exception('No properties found for this user.');
            }
        } else {
            throw new Exception('No accounts found for this user.');
        }
    }

    private function ga_init()
    {
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = base_path() . '/ga-abbc95bccb9d.json';
//        print_r($KEY_FILE_LOCATION);die;
        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName("Hello Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_Analytics($client);

        return $analytics;
    }


    public function coupon_analytic()
    {
        return view('admin.pages.analytic.coupon');
    }

    public function store_analytic()
    {
        return view('admin.pages.analytic.store');
    }

}
