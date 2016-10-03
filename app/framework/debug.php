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
        $output = "<pre style='border: 1px solid #ccc; background: #f5f5f5; color: #333; padding: 10px'><code>"
                . "<strong>$file($line)</strong> <i>$type($count)</i>\r\n";
        if ($detailed):
            ob_start();
            var_dump($array);
            $output .= ob_get_clean();
        else:
            $output .= print_r($array, true);
        endif;
        $output .= "</code></pre>";
        echo $output;
        if ($exit):
            exit;
        endif;
    }

}
