<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class TestView extends View {

    public function run() {
        
    }

    public function test($variables) {
        $this->setHeader('Content-Type', 'utf8');
        $variables['app'] = Configuration::readAll();
        $variables['user'] = $this->service('authentication')->user();
        $r = $this->renderer('templates');
        $r->layout('layouts/layout.html', function() use ($r) {
            return $r->container('containers/container.html', function() use ($r) {
                        return $r->loadTemplate('navigation.html') .
                                $r->loadTemplate('home.html') .
                                $r->loadTemplate('debug.html');
                    });
        });
        $html = $r->apply($variables);
        print $html;
    }

}
