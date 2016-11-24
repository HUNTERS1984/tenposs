<?php
include "GoogleAnalyticsProcess.php";
include "Utilities.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    if (isset($_GET['from_date']) && isset($_GET['to_date'])
        && isset($_GET['time_type']) && isset($_GET['report_type'])
        && isset($_GET['data_type'])
    ) {
        if (Utilities::checkDateFormatYmd($_GET['from_date'])
            && Utilities::checkDateFormatYmd($_GET['to_date'])
        ) {
            $ga = new GoogleAnalyticsProcess();
            $ga->getFirstProfileId();
            $dimension = Utilities::get_dimension_from_time_type($_GET['time_type']);
            $results = $ga->getData($_GET['from_date'], $_GET['to_date'],
                $_GET['report_type'], $dimension);

//          $metrics = 'ga:visits,ga:pageviews,ga:bounces,ga:entranceBounceRate,ga:visitBounceRate,ga:avgTimeOnSite';
//          $dimensions = 'ga:date,ga:year,ga:month,ga:week,ga:day';
            if (null != $results) {
                if (count($results->getRows()) > 0) {

                    // Get the profile name.
                    $profileName = $results->getProfileInfo()->getProfileName();
                    // Get the entry for the first entry in the first row.
                    $rows = $results->getRows();
                    $arr_label = array();
                    $arr_data = array();
                    for ($i = 0; $i < count($rows); $i++) {
                        $arr_label[] = $rows[$i][0];
                        $arr_data[] = $rows[$i][1];
                    }
                    $arr_data = array(
                        "name" => $profileName,
                        "label" => $arr_label,
                        "data_chart" => $arr_data
                    );
                    $arr = array("code" => '1000', "message" => 'Success', "data" => $arr_data);
                    echo json_encode($arr);

                } else {
                    $arr = array("code" => '1001', "data" => 'Data not exists');
                    echo json_encode($arr);
                }
            } else {
                $arr = array("code" => '9999', "message" => 'Exception error.');
                echo json_encode($arr);
            }
        } else {
            $arr = array("code" => '1020', "message" => 'Date not format.');
            echo json_encode($arr);
        }
    } else {
        $arr = array("code" => '1002', "message" => 'Parameter is not enought.');
        echo json_encode($arr);
    }
} else { //method post not allow
    $arr = array("code" => '9997', "message" => 'Parameter is not enought.');
    echo json_encode($arr);
}