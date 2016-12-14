<?php
include "GoogleAnalyticsProcess.php";
include "Utilities.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    if (isset($_GET['from_date']) && isset($_GET['to_date'])
        && isset($_GET['data_type'])
    ) {
        if (Utilities::checkDateFormatYmd($_GET['from_date'])
            && Utilities::checkDateFormatYmd($_GET['to_date'])
        ) {
            $ga = new GoogleAnalyticsProcess();
            $ga->getFirstProfileId();
            if ($_GET['data_type'] == 'all') {
                $arr_list_metric = Utilities::get_list_metric();
                $arr_result = array();
                if (count($arr_list_metric) > 0) {
                    foreach ($arr_list_metric as $item) {
                        $results = $ga->get_data_total($_GET['from_date'], $_GET['to_date'], $item);
                        $arr_result_detail = array('report_type' => $item);
                        $arr_result_detail['total'] = 0;
                        if (null != $results) {
                            if (count($results->getRows()) > 0) {
                                $rows = $results->getRows();
                                $arr_result_detail['total'] = $rows[0][0];
                            }
                        }
                        $arr_result[] = $arr_result_detail;
                    }
                    $arr = array("code" => '1000', "message" => 'Success', "data" => $arr_result);
                    echo json_encode($arr);
                } else {
                    $arr = array("code" => '1003', "message" => 'Metric config not found.');
                    echo json_encode($arr);
                }
            } else if ($_GET['data_type'] == 'total') {
                $results = $ga->get_data_total($_GET['from_date'], $_GET['to_date'],
                    $_GET['report_type']);
                if (null != $results) {
                    if (count($results->getRows()) > 0) {
                        $rows = $results->getRows();
                        $arr_detail = array('report_type' => $_GET['report_type'],
                            'total' => $rows[0][0]);
                        $arr = array("code" => '1000', "message" => 'Success', "data" => $arr_detail);
                        echo json_encode($arr);
                    } else {
                        $arr = array("code" => '1001', "data" => 'Data not exists');
                        echo json_encode($arr);
                    }
                } else {
                    $arr = array("code" => '9999', "message" => 'Exception error.');
                    echo json_encode($arr);
                }
            } else if ($_GET['data_type'] == 'detail') {
                $dimension = Utilities::get_dimension_from_time_type($_GET['time_type']);
                $results = $ga->get_data($_GET['from_date'], $_GET['to_date'],
                    $_GET['report_type'], $dimension);

                if (null != $results) {
                    if (count($results->getRows()) > 0) {
                        $profileName = $results->getProfileInfo()->getProfileName();
                        $rows = $results->getRows();

                        $arr_label = array();
                        $arr_data = array();
                        for ($i = 0; $i < count($rows); $i++) {
                            $arr_label[] = Utilities::convertDateToJapan($rows[$i][0], $_GET['time_type'], $_GET['to_date']);
                            $arr_data[] = $rows[$i][1];
                        }
                        $arr_data = array(
                            'report_type' => $_GET['report_type'],
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
                $arr = array("code" => '9998', "message" => 'data type not support.');
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