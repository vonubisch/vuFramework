<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
abstract class Service extends Framework {

    abstract public function run();

    public function requires($name) {
        if (!Services::check($name)):
            throw new ServiceException(Exceptions::FILENOTFOUND . $name);
        endif;
    }

}
