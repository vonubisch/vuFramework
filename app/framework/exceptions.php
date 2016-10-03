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

    const SHUTDOWN = 'Site is temporarily shutdown.';
    const SAFEMSG = 'Oops! An fatal error has occured.';
    const FILENOTFOUND = 'File not found: ';
    const KEYNOTFOUND = 'Key not found: ';
    const PATHNOTFOUND = 'Path not found: ';
    const CLASSNAMENOTFOUND = 'Classname not found: ';

    public function show($errors = false, $logfile = NULL, $configuration = array()) {
        $code = $this->generateCode(microtime(true));
        if ((bool) $errors):
            $msg = $this->detailedMessage($configuration, $code);
        else:
            $msg = $this->safeMessage($code);
        endif;
        if ((bool) ini_get('log_errors') && !is_null($logfile)) {
            $this->logError($logfile, $code);
        }
        die($msg);
    }

    private function logError($file, $code) {
        $date = date('Y-m-d H:i:s');
        $class = get_class($this);
        $msg = $this->getMessage();
        $url = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $ua = base64_encode(filter_input(INPUT_SERVER, 'HTTP_USER_AGENT'));
        $log = "{$date} [{$class}] {$msg} ({$url}) {{$ip},{$code},{$ua}}";
        error_log($log . PHP_EOL, 3, $file);
    }

    private function detailedMessage($config, $code) {
        $class = get_class($this);
        $msg = $this->getMessage();
        $EOL = PHP_EOL;
        $trace = $this->getTraceAsString();
        $cfg = print_r($config, true);
        return "<pre><strong>{$class}</strong> {$msg}{$EOL}<sup>{$code}</sup>{$EOL}<small><em>{$trace}</em>{$EOL}{$EOL}{$cfg}</small></pre>";
    }

    private function safeMessage($code) {
        $msg = self::SAFEMSG;
        return "<pre><strong>{$msg}</strong><br><small><i>{$code}</i></small></pre>";
    }

    private function generateCode($string) {
        return base64_encode($string);
    }

}
