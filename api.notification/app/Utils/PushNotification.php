<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 8/26/16
 * Time: 6:01 AM
 */

namespace App\Utils;

use Illuminate\Support\Facades\Config;

class PushNotification
{
    private $gooole_url;
    private $web_url;
    private $apple_url;
    protected static $_instance = null;

    public function __construct()
    {
        $this->gooole_url = Config::get('api.noti_google_url');
        $this->apple_url = Config::get('api.noti_apple_url');
        $this->web_url =  Config::get('api.noti_web_url');
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Sends Push notification for Android users
    public function android($data, $reg_id, $api_access_key)
    {
        $message = array(
            'title' => $data['title'],
            'message' => $data['desc'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'id' => $data['id'],
            'type' => $data['type'],
            'image_url' => $data['image_url']
        );

        $headers = array(
            'Authorization: key=' . $api_access_key,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => array($reg_id),
            'data' => $message,
        );

        $result = $this->useCurl($this->gooole_url, $headers, json_encode($fields));
        print_r($result);die;
        if ($this->isJson($result)) {
            return true;
        } else {
            return false;
        }
    }

    // Sends Push notification for Android users
    public function web($data, $reg_id, $api_access_key)
    {
        $message = array(
            'title' => $data['title'],
            'message' => $data['desc'],
            'subtitle' => '',
            'tickerText' => '',
            'msgcnt' => 1,
            'vibrate' => 1,
            'id' => $data['id'],
            'type' => $data['type'],
            'image_url' => $data['image_url']
        );

        $headers = array(
            'Authorization: key=' . $api_access_key,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => array($reg_id),
            'data' => $message,
        );

        $result = $this->useCurl($this->web_url, $headers, json_encode($fields));

        if ($this->isJson($result)) {
            return true;
        } else {
            return false;
        }
    }

    // Sends Push notification for iOS users
    public function iOS($data, $device_token, $path_pem_file, $pass_cer)
    {
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', $path_pem_file);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $pass_cer);
        // Open a connection to the APNS server
        $fp = stream_socket_client(
            $this->apple_url, $err,
            $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'title' => $data['title'],
                'body' => $data['desc'],
            ),
            'sound' => 'default'
        );
        $body['data'] = array('type' => $data['type'],
            'id' => $data['id'], 'image_url' => $data['image_url']);
        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        if (!$result)
            return false;//'Message not delivered' . PHP_EOL;
        else
            return true;//'Message successfully delivered' . PHP_EOL;
    }

    // Curl
    private function useCurl($url, $headers, $fields = null)
    {
        // Open connection
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                return 'Curl failed: ' . curl_error($ch);
            }
            // Close connection
            curl_close($ch);

            return $result;
        }
    }

    function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}