<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Session {

    private static $salt = 'Zgu0MW&T$@HKDSdsd9@[@&SDtoUI()&*7LDSH/$#,.dsp[rewr^%wewd8u390-uSOI":23uB';

    public static function close() {
        session_destroy();
    }

    public static function read($id) {
        return (isset($_SESSION[$id])) ? $_SESSION[$id] : false;
    }

    public static function exist($id) {
        return isset($_SESSION[$id]);
    }

    public static function regenerateId() {
        session_regenerate_id(true);
    }

    public static function generateId($maxLength = 64) {
        $entropy = '';
        // try ssl first
        if (function_exists('openssl_random_pseudo_bytes')) {
            $entropy = openssl_random_pseudo_bytes(64, $strong);
            // skip ssl since it wasn't using the strong algo
            if ($strong !== true) {
                $entropy = '';
            }
        }
        // add some basic mt_rand/uniqid combo
        $entropy .= uniqid(mt_rand(), true);
        // try to read from the windows RNG
        if (class_exists('COM')) {
            try {
                $com = new COM('CAPICOM.Utilities.1');
                $entropy .= base64_decode($com->GetRandom(64, 0));
            } catch (Exception $ex) {
                
            }
        }
        // try to read from the unix RNG
        if (@is_readable('/dev/urandom')) {
            $h = fopen('/dev/urandom', 'rb');
            $entropy .= fread($h, 64);
            fclose($h);
        }
        $hash = hash('whirlpool', $entropy);
        if ($maxLength) {
            return substr($hash, 0, $maxLength);
        }
        return $hash;
    }

    public static function write($id, $data, $lifetime = false) {
        if ($lifetime):
            $_SESSION[$id . "_created"] = time();
        endif;
        $_SESSION[$id] = $data;
    }

    public static function destroy($id) {
        if (isset($_SESSION[$id])):
            unset($_SESSION[$id]);
        endif;
    }

    public static function gc($maxlifetime) {
        // your code
    }

}
