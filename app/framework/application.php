<?php

/**
 * Application class, boots up whole framework 
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
require_once 'debug.php';
require_once 'exceptions.php';
require_once 'configuration.php';
require_once 'router.php';
require_once 'factory.php';

class Application {

    public function __construct($config) {
        try {
            Configuration::init($config);

            Configuration::write('enviroment', $this->setEnviroment(Configuration::get('enviroments')));
            $this->handleShutdown(Configuration::read('enviroment.shutdown'));
            $this->setErrors(Configuration::read('enviroment.errors'));
            $this->setLogging(Configuration::read('enviroment.logging'));

            
            Router::init(Configuration::get('routes'), Configuration::read('enviroment.folder'));
            Configuration::write('route', Router::route());

            Debug::dump(Configuration::readAll());

            //Router::dispatch(Configuration::read('routes'));
            //Configuration::write('route', Router::route());
        } catch (Exceptions $error) {
            $error->show(
                    Configuration::read('enviroment.errors'), Configuration::read('enviroment.errorlog'), Configuration::readAll()
            );
        }
    }

    public function start() {
        Debug::dump('Application started');
    }

    private function setEnviroment($envs) {
        return reset($envs);
    }

    private function handleShutdown($bool = true) {
        if (!(bool) $bool):
            return;
        endif;
        die(Exceptions::SHUTDOWN);
    }

    private function setErrors($bool = false) {
        if ((bool) $bool) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
    }

    private function setLogging($bool = false) {
        if ((bool) $bool) {
            ini_set('log_errors', 1);
        } else {
            ini_set('log_errors', 0);
        }
    }

}
