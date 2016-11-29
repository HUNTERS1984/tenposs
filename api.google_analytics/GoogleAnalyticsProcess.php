<?php

/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 11/22/16
 * Time: 1:11 PM
 */
require_once __DIR__ . '/vendor/autoload.php';

class GoogleAnalyticsProcess
{
    const GOOGLE_ANALYTICS_URL = "https://www.googleapis.com/auth/analytics.readonly";
    const APPLICATION_NAME = "Ten-po.com";
    public $auth = null;
    public $profile_id = null;

    public function __construct()
    {
        $KEY_FILE_LOCATION = __DIR__ . '/ga-abbc95bccb9d.json';
        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes([self::GOOGLE_ANALYTICS_URL]);
        $this->auth = new Google_Service_Analytics($client);
    }

    function getFirstProfileId()
    {
        $accounts = $this->auth->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();
            $properties = $this->auth->management_webproperties
                ->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();
                $profiles = $this->auth->management_profiles
                    ->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    $this->profile_id = $items[0]->getId();

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

    function get_data($from_date, $to_date, $metrics, $dimensions)
    {
        try {
            return $this->auth->data_ga->get(
                'ga:' . $this->profile_id,
                $from_date,
                $to_date,
                $metrics, array('dimensions' => $dimensions));

        } catch (Exception $e) {
            print_r($e->getMessage());
            die;
            return null;
        }
    }

    function get_data_total($from_date, $to_date, $metrics)
    {
//        $from = date('Y-m-d', time() - 2 * 24 * 60 * 60); // 2 days
//        $to = date('Y-m-d'); // today
        try {
            return $this->auth->data_ga->get(
                'ga:' . $this->profile_id,
                $from_date,
                $to_date,
                $metrics);

        } catch (Exception $e) {
            print_r($e->getMessage());
            die;
            return null;
        }
    }

}