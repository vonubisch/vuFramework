<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
abstract class Controller extends Framework {

    private $binds = array();

    abstract public function run();

    public function __construct() {
        
        
    }

    public final function bind($key, $value) {
        $this->binds[$key] = $value;
    }

    public final function binds() {
        $this->bind('app', Configuration::appdata());
        $this->bind('debug', Debug::data());
        $this->bind('service', Services::binds());
        return $this->binds;
    }

}
