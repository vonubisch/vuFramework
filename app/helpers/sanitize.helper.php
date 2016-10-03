<?php

/**
 * Sanitize
 *
 * Extending PHP built-in functions
 *
 * @package    vuFramework 3.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2013 Carlsen Group - vonUbisch.com
 * @todo       
 */
class Sanitize {

    public static function text($input, $all = false) {
        return ($all) ? htmlentities($input, ENT_QUOTES, 'utf-8') : htmlspecialchars($input, ENT_QUOTES, 'utf-8');
    }

    public static function trim($input) {
        return trim($input);
    }

    public static function string($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    public static function encode($input) {
        return filter_var($input, FILTER_SANITIZE_ENCODED);
    }

    public static function url($input) {
        return filter_var($input, FILTER_SANITIZE_URL);
    }

    public static function special($input) {
        return filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public static function email($input) {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    public static function int($input) {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function float($input) {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    public static function alphanum($input, $replace = '') {
        return preg_replace("/[^a-zA-Z0-9]+/", $replace, $input);
    }

    public static function alpha($input, $replace = '') {
        return preg_replace("/[^A-Z]+/", $replace, $input);
    }

    public static function slug($text, $replace = '-') {
        $text = preg_replace('~[^\\pL\d]+~u', $replace, $text);
        $text = trim($text, $replace);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        return trim($text, $replace);
    }

}
