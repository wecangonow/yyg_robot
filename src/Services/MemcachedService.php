<?php

/**
 * Created by PhpStorm.
 * User: og
 * Date: 16/11/22
 * Time: 下午2:00
 */

namespace  Yyg\Robot\Services;

class MemcachedService
{
    private static $instance = null;

    public static function GetInstance()
    {
        $config = \Yyg\Robot\Configuration\RobotServerConfiguration::instance()->memcache_config;

        if(self::$instance == null)
        {
            self::$instance = new \Memcached();
            self::$instance->addServer($config['host'], $config['port']);
        }

        return self::$instance;

    }

    public static function Increment($key, $offset)
    {
        return self::GetInstance()->increment($key, $offset);
    }

    public static function Set($key, $value, $expire = 0)
    {
        self::GetInstance()->set($key, $value, $expire);
    }

    public static function Get($key)
    {
        return self::GetInstance()->get($key);
    }

    public static function FlushAll()
    {
        self::GetInstance()->flush();
    }

    public static function Delete($key, $time = 0)
    {
        return self::GetInstance()->delete($key, $time);
    }

}