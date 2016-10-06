<?php

/**
 * Configuration
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Configuration {

    private static $config = array();
    private static $separator = '.';
    private static $replace = '*';

    public static function init($configFile) {
        if (file_exists($configFile)):
            self::$config = parse_ini_file($configFile, true);
        else:
            throw new ConfigurationException(Exceptions::FILENOTFOUND . $configFile);
        endif;
    }

    public static function extend($file) {
        $path = self::path('config', $file);
        if (file_exists($path)):
            self::$config[$file] = parse_ini_file($path, true);
        else:
            throw new ConfigurationException(Exceptions::FILENOTFOUND . $file);
        endif;
    }

    public static function get($file) {
        $path = self::path('config', $file);
        if (file_exists($path)):
            return parse_ini_file($path, true);
        else:
            throw new ConfigurationException(Exceptions::FILENOTFOUND . $file);
        endif;
    }

    public static function read($key) {
        $config = self::$config;
        foreach (explode(self::$separator, $key) as $k):
            if (!array_key_exists($k, $config)):
                return NULL;
            endif;
            $config = $config[$k];
        endforeach;
        return $config;
    }

    public static function readAll() {
        return self::$config;
    }
    
    public static function write($key, $value) {
        self::$config[$key] = $value;
    }

    public static function classname($key, $input = '') {
        if (!isset(self::$config['classnames'][$key])):
            throw new ConfigurationException(Exceptions::CLASSNAMENOTFOUND . $key);
        endif;
        return str_replace(self::$replace, $input, self::$config['classnames'][$key]);
    }

    public static function path($key, $input = '') {
        if (!isset(self::$config['paths'][$key])):
            throw new ConfigurationException(Exceptions::PATHNOTFOUND . $key);
        endif;
        return str_replace(self::$replace, $input, self::$config['paths'][$key]);
    }

}
