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

    private static $console = array();

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

    public static function console($data) {
        $bt = debug_backtrace();
        $text = $data;
        switch (gettype($data)):
            case 'boolean':
                $text = ($data) ? 'true' : 'false';
                break;
            case 'NULL':
                $text = 'NULL';
                break;
        endswitch;
        self::$console[] = array(
            'type' => self::type($data),
            'file' => basename($bt[0]['file']),
            'line' => $bt[0]['line'],
            'data' => $text
        );
    }

    public static function type($variable) {
        $type = gettype($variable);
        switch ($type):
            case 'string':
                $method = 'strlen';
                break;
            case 'object':
                $method = 'get_class';
                break;
            default:
                $method = 'count';
        endswitch;
        return $type . '(' . $method($variable) . ')';
    }

    public static function log($data) {
        file_put_contents(Configuration::path('logs', 'debug'), print_r($data, true));
    }

    public static function getLog($file) {
        $lines = array(0 => 'd');
        $handle = fopen(Configuration::path('logs', $file), "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $lines[] = $line;
            }
            fclose($handle);
        } else {
            throw new Exception("Exceptions log file not found for debugging");
        }
        unset($lines[0]);
        return implode("\n", array_reverse($lines, true));
    }

    public static function data($binds) {
        if (error_reporting() === 0):
            return array();
        endif;
        $data = array();
        $data['Console'] = self::$console;
        $data['Binds'] = $binds;
        $data['Configuration'] = Configuration::readAll();
        $data['Routes'] = Router::routes();
        $data['Services'] = Services::objects();
        $data['Request'] = array('get' => $_GET, 'post' => $_POST, 'files' => $_FILES, 'cookie' => $_COOKIE, 'session' => $_SESSION);
        $data['Exceptions'] = self::getLog('errors');
        $data['Server'] = $_SERVER;
        return $data;
    }

}
