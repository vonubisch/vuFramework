<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
abstract class View extends Framework {

    private $headers = array(
        'Content-Type' => array(
            'utf8' => 'text/html;charset=utf-8',
            'json' => 'application/json',
            'atom' => 'application/atom+xml',
            'css' => 'text/css',
            'javascript' => 'text/javascript',
            'jpg ' => 'image/jpeg',
            'pdf' => 'application/pdf',
            'rss' => 'application/rss+xml; charset=ISO-8859-1',
            'plaintext' => 'text/plain',
            'xml' => 'text/xml',
            'png' => 'image/png',
            'mpeg' => 'video/mpeg',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'doc' => 'application/msword',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'download' => 'application/octet-stream'
        )
    );

    abstract public function run();

    public final function renderer($name, $options = array()) {
        return Factory::renderer($name, $options);
    }

}
