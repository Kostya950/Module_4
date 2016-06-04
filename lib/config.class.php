<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 22.05.16
 * Time: 15:44
 */

class Config
{
    protected static $settings = [];

    public static function get($key)
    {
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    public static function set($key, $value)
    {
        self::$settings[$key] = $value;
    }

}