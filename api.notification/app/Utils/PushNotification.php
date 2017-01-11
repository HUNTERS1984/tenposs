<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 8/26/16
 * Time: 6:01 AM
 */

namespace App\Utils;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PushNotification
{
    protected $pushStream;
    private $connection_start;
    private $timeout;

    private $gooole_url;
    private $web_url;
    private $apple_url;
    protected static $_instance = null;

    public function __construct()
    {
        $this->gooole_url = Config::get('api.noti_google_url');
        $this->apple_url = Config::get('api.noti_apple_url');
        $this->web_url = Config::get('api.noti_web_url');

        $this->timeout = 60;
        $this->connection_start = 0;
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Sends Push notification for Android users
    public function android($data, $reg_id, $api_access_key, $array_append_data = array())
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
        if (count($array_append_data) > 0)
            $message = array_merge($message, $array_append_data);

        $headers = array(
            'Authorization: key=' . $api_access_key,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => array($reg_id),
            'data' => $message,
        );

        $result = $this->useCurl($this->gooole_url, $headers, json_encode($fields));
        Log::info("android: " . $result);
        if ($this->isJson($result)) {
            return true;
        } else {
            return false;
        }
    }

    // Sends Push notification for Android users
    public function web($data, $reg_id, $api_access_key, $array_append_data = array())
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
        if (count($array_append_data) > 0)
            $message = array_merge($message, $array_append_data);

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



    protected function connect($path_pem_file, $pass_cer) {
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $path_pem_file);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $pass_cer);

        $stream = stream_socket_client($this->apple_url, $err, $errstr, $this->timeout, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        Log::info("APN: Maybe some errors: $err: $errstr");
        
        
        if (!$stream) {
          
          if ($err)
            Log::error( "APN Failed to connect: $err $errstr");
          else
            Log::error( "APN Failed to connect: Something wrong with context");
            
          return false;
        }
        else {
          stream_set_timeout($stream,20);
          Log::info("APN: Opening connection to: {$this->apple_url}");
          return $stream;
        }
      }

    function disconnectPush()
    {
        Log::info("APN: disconnectPush");
        if ($this->pushStream && is_resource($this->pushStream))
        {
          $this->connection_start = 0;
          return @fclose($this->pushStream);
        }
        else
          return true;
    }

    protected function timeoutSoon($left_seconds = 5)
    {
        $t = ( (round(microtime(true) - $this->connection_start) >= ($this->timeout - $left_seconds)));
        return (bool)$t;
    }


    protected function reconnectPush($path_pem_file, $pass_cer)
    {
        $this->disconnectPush();
            
        if ($this->connectToPush($path_pem_file, $pass_cer))
        {
          Log::info("APN: reconnect");
          return true;
        }
        else
        {
          Log::info("APN: cannot reconnect");
          return false;
        }
    }
  
    protected function tryReconnectPush($path_pem_file, $pass_cer)
    {   

        if($this->timeoutSoon())
        {
            return $this->reconnectPush($path_pem_file, $pass_cer);
        }
        
        return false;
    }
    public function connectToPush($path_pem_file, $pass_cer)
    {
        if (!$this->pushStream or !is_resource($this->pushStream))
        {
          Log::info("APN: connectToPush");

          $this->pushStream = $this->connect($path_pem_file, $pass_cer);
          
          if ($this->pushStream)
          {
            $this->connection_start = microtime(true);
            //stream_set_blocking($this->pushStream,0);
          }
        }

        return $this->pushStream;
    }

    public function iOS_stream($data, $device_token, $path_pem_file, $pass_cer, $array_append_data = array())
    {
        if (!ctype_xdigit($device_token))
        {
          Log::info("APN: Error - '$deviceToken' token is invalid. Provided device token contains not hexadecimal chars");
          $this->error = 'Invalid device token. Provided device token contains not hexadecimal chars';
          return false;
        }
        
        

        // restart the connection
        $this->tryReconnectPush($path_pem_file, $pass_cer);

        
        // Create the payload body
        $body['aps'] = array(
            'alert' => ''.$data['title'],
            'sound' => 'default'
        );
        $body['data'] = array('type' => $data['type'], 'desc' => $data['desc'],
            'id' => $data['id'], 'image_url' => $data['image_url']);
        if (count($array_append_data) > 0)
            $body['data'] = array_merge($body['data'], $array_append_data);

        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;
        
        if (!is_resource($this->pushStream))
            $this->reconnectPush();

        // Send it to the server
        $result = fwrite($this->pushStream, $msg, strlen($msg));
        if (!$result) {
            Log::info("APN: send not ok");
            return false;
        } else {
            Log::info("APN: send OK");
            return true;
        }
    }


    // Sends Push notification for iOS users
    public function iOS($data, $device_token, $path_pem_file, $pass_cer, $array_append_data = array())
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
            // 'alert' => array(
            //     'title' => $data['title'],
            //     'body' => $data['desc'],
            // ),
            'alert' => ''.$data['title'],
            'sound' => 'default'
        );
        $body['data'] = array('type' => $data['type'], 'desc' => $data['desc'],
            'id' => $data['id'], 'image_url' => $data['image_url']);
        if (count($array_append_data) > 0)
            $body['data'] = array_merge($body['data'], $array_append_data);

        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);
        Log::info("ios: " . $result);
        if (!$result) {
            Log::info("APN: send not OK");
            return false;
        } else {
            Log::info("APN: send OK");
            return true;
        }
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