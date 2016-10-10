<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
abstract class Framework {

    public final function controller($name, $method) {
        return Factory::controller($name, $method);
    }

    public final function service($name) {
        return Services::get($name);
    }

    public final function model($name, $properties = array()) {
        return Factory::model($name, $properties);
    }

    public final function dao($name) {
        return Factory::dao($name);
    }

    public final function view($name) {
        return Factory::view($name);
    }

    public final function library($name) {
        return Factory::library($name);
    }

    public final function helper($name) {
        return Factory::helper($name);
    }

    public final function parameter($key) {
        return Configuration::read('route.parameters.' . $key);
    }

    public final function query($key) {
        return Configuration::read('route.queries.' . $key);
    }

    public final function url($name, $parameters = array()) {
        return Router::generate($name, $parameters);
    }

    public final function redirect($route = NULL, $parameters = array()) {
        if (is_null($route)):
            $url = Configuration::read('enviroment.base');
        endif;
        $url = $this->url($route, $parameters);
        header('Location: ' . $url);
        exit;
    }

    public final function redirectURL($url = false) {
        if ($url === false):
            $url = Configuration::read('enviroment.base');
        endif;
        header('Location: ' . $url);
        exit;
    }

    public final function request($request) {
        return Request::method($request);
    }

    public final function post($key = NULL, $filter = FILTER_DEFAULT, $flags = NULL) {
        return Request::post($key, $filter, $flags);
    }

    public final function get($key = NULL, $filter = FILTER_DEFAULT, $flags = NULL) {
        return Request::get($key, $filter, $flags);
    }

    public final function setHeader($key, $value) {
        switch ($key):
            case 'Content-Type':
                $type = $this->headers('Content-Type', $value);
                if (!is_null($type)):
                    $value = $type;
                endif;
                break;
        endswitch;
        header("{$key}: {$value}");
    }

    public final function headers($type, $key) {
        if (!isset($this->headers[$type][$key])):
            return NULL;
        endif;
        return $this->headers[$type][$key];
    }

}
