<?php

abstract class Framework {

    public final function controller($name, $method) {
        return Factory::controller($name, $method);
    }

    public final function service($name) {
        return Services::get($name);
    }

    public function model($name, $properties = array()) {
        return Factory::model($name, $properties);
    }

    public function dao($name) {
        return Factory::dao($name);
    }

    public function view($name) {
        return Factory::view($name);
    }

    public function helper($name) {
        return Factory::helper($name);
    }

    public final function parameter($key) {
        return Configuration::read('route.parameters.' . $key);
    }

    public final function query($key) {
        return Configuration::read('route.queries.' . $key);
    }

    public final function url($name) {
        return Router::generate($name);
    }

    public final function redirect($route = NULL, $url = false) {
        if (is_null($route) && $url === false):
            $url = Configuration::read('enviroment.base');
        endif;
        if (!$url):
            $url = $this->url($route);
        endif;
        header('Location: ' . $url);
        exit;
    }

    public final function request($request = NULL) {
        if (is_null($request)):
            return strtoupper($_SERVER['REQUEST_METHOD']);
        endif;
        return (strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($request));
    }

    public final function post($key = NULL, $filter = FILTER_DEFAULT, $flags = NULL) {
        if (is_null($key)):
            return $this->request(__FUNCTION__);
        elseif (empty($_POST[$key])):
            return '';
        endif;
        return trim(filter_input(INPUT_POST, $key, $filter, $flags));
    }

    public final function get($key = NULL, $filter = FILTER_DEFAULT, $flags = NULL) {
        if (is_null($key)):
            return $this->request(__FUNCTION__);
        endif;
        if (empty($_GET[$key])):
            return false;
        endif;
        return trim(filter_input(INPUT_GET, $key, $filter, $flags));
    }

    public final function ssl() {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443);
    }

}
