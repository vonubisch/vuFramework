<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
abstract class Driver {

    private $handle = NULL;

    abstract public function run($options);

    public final function setHandle($handle) {
        $this->handle = $handle;
    }

    public final function getHandle() {
        if (is_null($this->handle)):
            throw new DriverException('Driver handle not initiated');
        endif;
        return $this->handle;
    }

}
