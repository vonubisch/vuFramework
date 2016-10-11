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
        Debug::logPerformance('Factory built controller ' . $name);
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
        if (method_exists($object, Configuration::read('magic.constructor'))):
            $object->{Configuration::read('magic.constructor')}();
        endif;
        Debug::logPerformance('Factory built model ' . $name);
        return $object;
    }

    public static function view($name) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        Debug::logPerformance('Factory built view ' . $name);
        return $object;
    }

    public static function service($name) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        Debug::logPerformance('Factory built service ' . $name);
        return $object;
    }

    public static function helper($name) {
        self::load(__FUNCTION__, $name);
        Debug::logPerformance('Factory built helper ' . $name);
    }

    public static function language($name) {
        if (self::fileExists(__FUNCTION__, $name)):
            return parse_ini_file(self::path(__FUNCTION__, $name));
        else:
            throw new FactoryException(Exceptions::FILENOTFOUND . $name);
        endif;
        Debug::logPerformance('Factory built language ' . $name);
    }

    public static function library($name) {
        if (self::fileExists(__FUNCTION__, $name)):
            require_once self::path(__FUNCTION__, $name);
        else:
            throw new FactoryException(Exceptions::FILENOTFOUND . $name);
        endif;
        Debug::logPerformance('Factory built library ' . $name);
    }

    public static function dao($name) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}();
        Debug::logPerformance('Factory built DAO ' . $name);
        return $object;
    }

    public static function driver($name, $options = array()) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}($options);
        Debug::logPerformance('Factory built driver ' . $name);
        return $object;
    }

    public static function renderer($name, $options = array()) {
        self::load(__FUNCTION__, $name);
        $classname = self::classname(__FUNCTION__, $name);
        $object = new $classname();
        self::checkMethod($object, Configuration::read('magic.constructor'));
        $object->{Configuration::read('magic.constructor')}($options);
        Debug::logPerformance('Factory built renderer ' . $name);
        return $object;
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
        if (self::fileExists($type, $filepath)):
            require_once self::path($type, $filepath);
        else:
            throw new FactoryException(Exceptions::FILENOTFOUND . $filepath);
        endif;
    }

    public static function base($file) {
        if (self::fileExists(__FUNCTION__, $file)):
            require_once self::path(__FUNCTION__, $file);
        else:
            throw new FactoryException(Exceptions::FILENOTFOUND . $file);
        endif;
    }

    private static function basename($name) {
        return end((explode(Configuration::read('magic.delimiter'), $name)));
    }

    private static function fileExists($type, $file) {
        return file_exists(self::path($type, $file));
    }

    private static function classname($key, $input = '') {
        return self::basename(Configuration::classname($key, $input));
    }

    private static function path($key, $input = '') {
        return Configuration::path($key, $input);
    }

}
