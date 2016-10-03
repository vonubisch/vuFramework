<?php

/**
 * Accepts all requests, load and start application
 *
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
require_once 'app/framework/application.php';

$app = new Application('app/config/app.ini');
$app->start();
