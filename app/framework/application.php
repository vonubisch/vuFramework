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

    public function __construct() {
        try {
            Configuration::run('app/config/app.ini');
            Configuration::extend('enviroments');
            Configuration::extend('routes');
            Configuration::extend('settings');

            Exceptions::reporting(Configuration::read('enviroments'));


            Debug::dump(Configuration::readAll());

            //Router::dispatch(Configuration::read('routes'));
            //Configuration::write('route', Router::route());
        } catch (Exceptions $error) {
            $error->show(
                    'development', NULL, Configuration::readAll()
            );
        }
    }

    public function start() {
        Debug::dump('Application started');
    }

    private function shutdown() {
        
    }

}
