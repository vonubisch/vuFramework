<?php

/**
 * Factory
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Factory {

    public static function controller($name, $method) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        self::checkMethod($object, $method);
        $object->{$method}();
        return $object;
    }

    public static function model($name, $properties = array()) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        if ($properties):
            foreach ($properties as $k => $v):
                $object->{$k} = $v;
            endforeach;
        endif;
        return $object;
    }

    public static function view($name) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        return $object;
    }

    public static function service($name) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        return $object;
    }

    public static function helper($name) {
        self::load(__FUNCTION__, $name);
    }
    
    public static function library($name) {
        self::load(__FUNCTION__, $name);
    }

    public static function dao($name) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        return $object;
    }

    public static function renderer($name) {
        
    }

    private static function checkMethod($object, $method) {
        if (!method_exists($object, $method)):
            throw new FactoryException(Exceptions::METHODNOTFOUND . $method);
        endif;
    }

    private static function load($type, $file) {
        $filepath = str_replace(Configuration::read('magic.delimiter'), DIRECTORY_SEPARATOR, $file);
        if (!class_exists(self::classname($type))):
            self::base($type);
        endif;
        if (self::exists($type, $filepath)):
            require_once self::path($type, $filepath);
        else:
            throw new FactoryException(Exceptions::FILENOTFOUND . $filepath);
        endif;
    }

    public static function base($file) {
        if (self::exists(__FUNCTION__, $file)):
            require_once self::path(__FUNCTION__, $file);
        else:
            throw new FactoryException(Exceptions::FILENOTFOUND . $file);
        endif;
    }

    private static function basename($name) {
        return end((explode(Configuration::read('magic.delimiter'), $name)));
    }

    private static function exists($type, $file) {
        return file_exists(self::path($type, $file));
    }

    private static function classname($key, $input = '') {
        return self::basename(Configuration::classname($key, $input));
    }

    private static function path($key, $input = '') {
        return Configuration::path($key, $input);
    }

}
