<?php

/**
 * Languages
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>, Danny van Kooten (AltoRouter)
 * @copyright  2016 vonUbisch.com, altorouter.com
 */
class Languages {

    private static $initiated = false;
    private static $defaultLang = 'en';
    private static $selected = NULL;
    private static $dictionairy = NULL;

    public static function init() {
        self::$initiated = true;
        self::$selected = self::$defaultLang;
        self::$dictionairy = Factory::language(self::$selected);
        Debug::dump(self::$dictionairy);
    }

    public static function get($key) {
        if (!self::$initiated):
            //self::init();
        endif;
        //return self::$dictionairy[$key];
    }

}
