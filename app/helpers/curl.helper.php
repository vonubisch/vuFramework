<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class cURL {

    private $handle = NULL;
    private $url = NULL;
    private $response = NULL;
    private $errorno = true;
    private $error = '';
    private $info = array();
    private $options = array(
        CURLOPT_RETURNTRANSFER => true, // return web page
        CURLOPT_HEADER => false, // don't return headers
        CURLOPT_FOLLOWLOCATION => true, // follow redirects
        CURLOPT_MAXREDIRS => 3, // stop after 10 redirects
        CURLOPT_ENCODING => "", // handle compressed
        CURLOPT_AUTOREFERER => true, // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120, // time-out on connect
        CURLOPT_TIMEOUT => 120, // time-out on response
        CURLOPT_FAILONERROR => true
    );

    public function __construct($url = NULL) {
        if (!function_exists('curl_init')) {
            throw new vuHelperException("Curl PHP package not installed");
        }
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new vuHelperException("cURL URL '{$url}' is not a valid URL");
        }
        $this->url = $url;
        $this->handle = curl_init();
        $this->option(CURLOPT_URL, $this->url);
        $this->options($this->options);
    }

    public function option($key, $value) {
        curl_setopt($this->handle, $key, $value);
    }

    public function options($options) {
        curl_setopt_array($this->handle, $options);
    }

    public function post($fields = array(), $options = array()) {
        $this->option(CURLOPT_POSTFIELDS, http_build_query($fields));
        return $this->exec($options);
    }

    public function get($options = array()) {
        return $this->exec($options);
    }

    public function upload($file, $key = 'file', $options = array()) {
        $fields = array($key => '@' . realpath($file));
        $this->post($fields, $options);
    }

    public function exec($options = array()) {
        $this->options($options);
        $this->response = curl_exec($this->handle);
        $this->errorno = curl_errno($this->handle);
        $this->error = curl_error($this->handle);
        $this->info = curl_getinfo($this->handle);
        curl_close($this->handle);
        return $this->response();
    }

    public function info($key = NULL) {
        if (!is_null($key) && isset($this->info[$key])):
            return $this->info[$key];
        endif;
        return $this->info;
    }

    public function setUseragent($useragent) {
        $this->option(CURLOPT_USERAGENT, $useragent);
    }

    public function setReferer($referer) {
        $this->options(array(
            CURLOPT_AUTOREFERER => false,
            CURLOPT_REFERER => $referer
        ));
    }

    public function setAuthentication($username, $password) {
        $this->option(CURLOPT_USERPWD, $username . ':' . $password);
    }

    public function setHeader($headers) {
        if (is_array($headers)):
            $this->option(CURLOPT_HTTPHEADER, $headers);
        else:
            $this->option(CURLOPT_HTTPHEADER, array($headers));
        endif;
    }

    public function failed() {
        return $this->errorno;
    }

    public function success() {
        return !$this->failed();
    }

    public function error() {
        return $this->error;
    }

    public function response() {
        return $this->response;
    }

}
