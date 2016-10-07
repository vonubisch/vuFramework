<?php

/**
 * Debug
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Debug {

    public static function dump($array, $detailed = false, $exit = false) {
        if (error_reporting() === 0):
            return NULL;
        endif;
        switch (gettype($array)):
            case 'string':
                $method = 'strlen';
                break;
            case 'object':
                $method = 'get_class';
                break;
            default:
                $method = 'count';
        endswitch;
        $bt = debug_backtrace();
        $file = $bt[0]['file'];
        $line = $bt[0]['line'];
        $type = gettype($array);
        $count = $method($array);
        $output = "$file($line) $type($count)\r\n";
        if ($detailed):
            ob_start();
            var_dump($array);
            $output .= ob_get_clean();
        else:
            $output .= print_r($array, true);
        endif;
        echo $output;
        if ($exit):
            exit;
        endif;
    }

    public static function log($data) {
        $file = 'app/logs/debug.log';
        file_put_contents($file, print_r($data, true));
    }

}
