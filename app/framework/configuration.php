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

    public static function binds() {
        $data = array();
        $data['name'] = self::read('application.name');
        $data['author'] = self::read('application.author');
        $data['version'] = self::read('application.version');
        $data['base'] = self::read('enviroment.base');
        $data['folder'] = self::read('enviroment.folder');
        $data['errors'] = self::read('enviroment.errors');
        $data['logging'] = self::read('enviroment.logging');
        $data['shutdown'] = self::read('enviroment.shutdown');
        $data['route'] = self::read('route.name');
        $data['pattern'] = self::read('route.pattern');
        $data['controller'] = self::read('route.controller');
        $data['method'] = self::read('route.method');
        $data['parameters'] = self::read('route.parameters');
        $data['url'] = self::read('request.url');
        $data['queries'] = self::read('request.queries');
        $data['request'] = self::read('request.request');
        $data['get'] = self::read('request.get');
        $data['post'] = self::read('request.post');
        $data['ssl'] = self::read('request.ssl');
        $data['response'] = self::read('request.ssl');
        $data['memory'] = number_format(memory_get_peak_usage() / 1048576, 2);
        return $data;
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
