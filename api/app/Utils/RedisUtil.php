<?php
/**
 * Created by PhpStorm.
 * User: bangnk
 * Date: 8/18/16
 * Time: 9:14 AM
 */

namespace App\Utils;


use Illuminate\Support\Facades\Redis;
use Predis\Connection\ConnectionException;

class RedisUtil
{
    protected $_redis;
    protected static $_instance = null;

    public function __construct()
    {
        try {
            $this->_redis = Redis::connection();
        } catch (ConnectionException $e) {
        }
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function set_cache($key, $arrayData)
    {
        try {
            $this->_redis->set($key, json_encode($arrayData));
        } catch (ConnectionException $e) {

        } catch (\RedisException $e) {

        }
    }

    public function get_cache($key)
    {
        try {
            if ($this->_redis->get($key)) {
                return json_decode($this->_redis->get($key),true);
            }
        } catch (ConnectionException $e) {

        } catch (\RedisException $e) {

        }
        return null;
    }

}