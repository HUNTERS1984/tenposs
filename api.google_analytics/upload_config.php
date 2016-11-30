<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['file'])) {
        if ($_FILES['file']['error'] > 0) {
            $arr = array("code" => '9996', "message" => 'Upload file error.');
            echo json_encode($arr);
        } else {
            $user_id = $_POST['user_id'];
            $path = __DIR__ . '/uploads/';
            try {
                move_uploaded_file($_FILES['file']['tmp_name'], $path .$user_id.'_'. $_FILES['file']['name']);
            } catch (Exception $e) {
                $arr = array("code" => '9999', "message" => $e->getMessage());
                echo json_encode($arr);
            }
            $arr = array("code" => '1000', "message" => 'Success');
            echo json_encode($arr);
        }
    }
} else {
    $arr = array("code" => '9997', "message" => 'Parameter is not enought.');
    echo json_encode($arr);
}