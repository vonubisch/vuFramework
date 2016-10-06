<?php

/**
 * Services
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Services {

    private static $objects = array();

    public static function init($services) {
        foreach ($services as $service):
            self::$objects[$service] = Factory::service($service);
        endforeach;
    }

    public static function get($service) {
        if (!self::check($service)):
            throw new ServiceException(Exceptions::KEYNOTFOUND . $service);
        endif;
        return self::$objects[$service];
    }

    public static function check($service) {
        return isset(self::$objects[$service]);
    }

}
