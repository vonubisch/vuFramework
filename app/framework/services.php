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
    private static $binds = array();

    public static function init($services) {
        foreach ($services as $service):
            $object = Factory::service($service);
            if (method_exists($object, 'getBinds')):
                self::$binds = array_merge(self::$binds, $object->getBinds());
            endif;
            self::$objects[$service] = $object;
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

    public static function objects() {
        return self::$objects;
    }

    public static function binds() {
        return self::$binds;
    }

}
