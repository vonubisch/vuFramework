<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
abstract class Service extends Framework {

    private $binds = array();

    abstract public function run();

    public final function requires($name) {
        if (!Services::check($name)):
            throw new ServiceException(Exceptions::FILENOTFOUND . $name);
        endif;
    }

    public final function debug() {
        return $this;
    }

    public final function setBinds($key, $value) {
        $this->binds[$key] = $value;
    }

    public final function getBinds() {
        return $this->binds;
    }

}
