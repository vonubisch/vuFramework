<?php

/**
 * Request
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>, Danny van Kooten (AltoRouter)
 * @copyright  2016 vonUbisch.com, altorouter.com
 */
class Request {

    private static $data = array();

    public static function init() {
        self::$data['url'] = self::url($_SERVER);
        self::$data['queries'] = self::getQueries();
        self::$data['request'] = self::method();
        self::$data['get'] = self::method('get');
        self::$data['post'] = self::method('post');
        self::$data['ssl'] = self::ssl();
        self::$data['code'] = http_response_code();
    }

    public static function data() {
        return self::$data;
    }

    public static function method($request = NULL) {
        if (is_null($request)):
            return strtoupper($_SERVER['REQUEST_METHOD']);
        endif;
        return (strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($request));
    }

    public static function post($key = NULL, $filter = FILTER_DEFAULT, $flags = NULL) {
        if (is_null($key)):
            return self::method(__FUNCTION__);
        elseif (empty($_POST[$key])):
            return '';
        endif;
        return trim(filter_input(INPUT_POST, $key, $filter, $flags));
    }

    public static function get($key = NULL, $filter = FILTER_DEFAULT, $flags = NULL) {
        if (is_null($key)):
            return self::method(__FUNCTION__);
        endif;
        if (empty($_GET[$key])):
            return false;
        endif;
        return trim(filter_input(INPUT_GET, $key, $filter, $flags));
    }

    public static function ssl() {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443);
    }

    private static function getQueries() {
        $queries = array();
        parse_str(filter_input(INPUT_SERVER, 'QUERY_STRING'), $queries);
        return $queries;
    }

    private static function urlOrigin($s, $use_forwarded_host = false) {
        $ssl = self::ssl();
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . ( ( $ssl ) ? 's' : '' );
        $port = $s['SERVER_PORT'];
        $port = ( (!$ssl && $port == '80' ) || ( $ssl && $port == '443' ) ) ? '' : ':' . $port;
        $host = ( $use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST']) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null );
        $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    private static function url($s, $use_forwarded_host = false) {
        return self::urlOrigin($s, $use_forwarded_host) . $s['REQUEST_URI'];
    }

}
