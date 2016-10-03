<?php

/**
 * Exceptions
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
    if (0 === error_reporting()) {
        return false;
    }
    switch ($err_severity) {
        case E_ERROR: throw new ErrorException($err_msg, 0);
        case E_WARNING: throw new WarningException($err_msg, 0);
        case E_PARSE: throw new ParseException($err_msg, 0);
        case E_NOTICE: throw new NoticeException($err_msg, 0);
        case E_CORE_ERROR: throw new CoreErrorException($err_msg, 0);
        case E_CORE_WARNING: throw new CoreWarningException($err_msg, 0);
        case E_COMPILE_ERROR: throw new CompileErrorException($err_msg, 0);
        case E_COMPILE_WARNING: throw new CoreWarningException($err_msg, 0);
        case E_USER_ERROR: throw new UserErrorException($err_msg, 0);
        case E_USER_WARNING: throw new UserWarningException($err_msg, 0);
        case E_USER_NOTICE: throw new UserNoticeException($err_msg, 0);
        case E_STRICT: throw new StrictException($err_msg, 0);
        case E_RECOVERABLE_ERROR: throw new RecoverableErrorException($err_msg, 0);
        case E_DEPRECATED: throw new DeprecatedException($err_msg, 0);
        case E_USER_DEPRECATED: throw new UserDeprecatedException($err_msg, 0);
    }
});

class ControllerException extends Exceptions {
    
}

class ModelException extends Exceptions {
    
}

class ViewException extends Exceptions {
    
}

class DAOException extends Exceptions {
    
}

class DBException extends Exceptions {
    
}

class QueryException extends Exceptions {
    
}

class RoutingException extends Exceptions {
    
}

class LibraryException extends Exceptions {
    
}

class ConfigurationException extends Exceptions {
    
}

class DatabaseException extends Exceptions {
    
}

class FactoryException extends Exceptions {
    
}

class FrameworkException extends Exceptions {
    
}

class FormatException extends Exceptions {
    
}

class DeveloperException extends Exceptions {
    
}

class ShutdownException extends Exceptions {
    
}

class HelperException extends Exceptions {
    
}

class LanguageException extends Exceptions {
    
}

class WarningException extends Exceptions {
    
}

class ParseException extends Exceptions {
    
}

class NoticeException extends Exceptions {
    
}

class CoreErrorException extends Exceptions {
    
}

class CoreWarningException extends Exceptions {
    
}

class CompileErrorException extends Exceptions {
    
}

class CompileWarningException extends Exceptions {
    
}

class UserErrorException extends Exceptions {
    
}

class UserWarningException extends Exceptions {
    
}

class UserNoticeException extends Exceptions {
    
}

class StrictException extends Exceptions {
    
}

class RecoverableErrorException extends Exceptions {
    
}

class DeprecatedException extends Exceptions {
    
}

class UserDeprecatedException extends Exceptions {
    
}

class Exceptions extends Exception {

    public function shutdown($bool) {
        if (!(bool) $bool):
            return;
        endif;
        $this->reporting('production');
        throw new ShutdownException('Site is temporarily shutdown');
    }

    public static function reporting($env = 'production') {
        ini_set('log_errors', 1);
        switch ($env) {
            case 'production':
                error_reporting(0);
                ini_set("display_errors", 0);
                break;
            case 'development':
                error_reporting(E_ALL);
                ini_set("display_errors", 1);
                break;
        }
    }

    public function show($env = 'production', $logfile = NULL, $configuration = array()) {
        $msg = '';
        switch ($env) {
            case 'development':
                $msg = '<pre><strong>' .
                        get_class($this) .
                        ':</strong> ' .
                        $this->getMessage() .
                        PHP_EOL .
                        '<small><em>' .
                        $this->getTraceAsString() .
                        '</em>' .
                        PHP_EOL . PHP_EOL .
                        print_r($configuration, true) .
                        '</small></pre>';
                break;
            default:
            case 'production':
                $msg = '<pre><strong>' .
                        get_class($this) .
                        ':</strong> Fatal error!' .
                        '</pre>';
                break;
        }
        if (!is_null($logfile)) {
            $log = date('Y/m/d H:i:s') . " [" . get_class($this) . "] " . $this->getMessage() . " ({$_SERVER['REQUEST_URI']})" . PHP_EOL;
            error_log($log, 3, $logfile);
        }
        die($msg);
    }

}
