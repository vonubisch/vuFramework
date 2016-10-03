<?php

/**
 * Crypt
 *
 * En- and de-crypt for strings and urls
 *
 * @package    vuFramework 3.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @todo       
 */

class Crypt {

    public static $key, $ivs, $iv;

    /**
     *
     * This is called when we wish to set a variable
     *
     * @access    public
     * @param    string    $name
     * @param    string    $value
     *
     */
    public function __set($name, $value) {
        switch ($name) {
            case 'key':
            case 'ivs':
            case 'iv':
                $this->$name = $value;
                break;

            default:
                throw new vuHelperException("$name cannot be set");
        }
    }

    /**
     *
     * Gettor - This is called when an non existant variable is called
     *
     * @access    public
     * @param    string    $name
     *
     */
    public function __get($name) {
        switch ($name) {
            case 'key':
                return 'keee';

            case 'ivs':
                return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

            case 'iv':
                return mcrypt_create_iv(self::$ivs);

            default:
                throw new vuHelperException("$name cannot be called");
        }
    }

    /**
     *
     * Encrypt a string
     *
     * @access    public
     * @param    string    $text
     * @return    string    The encrypted string
     *
     */
    public static function encrypt($text) {
        // add end of text delimiter
        $data = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, self::$key, $text, MCRYPT_MODE_ECB, self::$iv);
        return base64_encode($data);
    }

    /**
     *
     * Decrypt a string
     *
     * @access    public
     * @param    string    $text
     * @return    string    The decrypted string
     *
     */
    public static function decrypt($text) {
        $text = base64_decode($text);
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, self::$key, $text, MCRYPT_MODE_ECB, self::$iv);
    }

    public static function encode($text) {
        return rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
    }

    public static function decode($text) {
        return base64_decode(str_pad(strtr($text, '-_', '+/'), strlen($text) % 4, '=', STR_PAD_RIGHT));
    }

}