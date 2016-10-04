<?php

/**
 * Databases
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Databases {

    private static $dbs = array();
    private static $handles = array();

    public static function init($databases = array()) {
        if ($databases):
            self::$dbs = $databases;
        endif;
    }

    public static function connect($name) {
        if (isset(self::$handles[$name])):
            return self::$handles[$name];
        endif;
        if (!isset(self::$dbs[$name])):
            throw new DBException(Exceptions::KEYNOTFOUND . $name);
        endif;
        $details = self::$dbs[$name];
        if (!isset($details['driver'])):
            throw new DBException(Exceptions::KEYNOTFOUND . 'driver');
        endif;
        if (!isset($details['options'])):
            throw new DBException(Exceptions::KEYNOTFOUND . 'options');
        endif;
        $driver = self::getDriver($details['driver'], $details['options']);
        self::$handles[$name] = $driver;
        return self::$handles[$name];
    }

    private static function getDriver($name, $options = array()) {
        return Factory::driver($name, $options);
    }

}
