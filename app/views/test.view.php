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

    public function test($binds) {
        $this->setHeader('Content-Type', 'utf8');
        $binds['app'] = Configuration::readAll();
        $r = $this->renderer('templates');
        $r->layout('layouts/layout.html', function() use ($r) {
            return $r->container('containers/container.html', function() use ($r) {
                        return $r->loadTemplate('navigation.html') .
                                $r->loadTemplate('home.html') .
                                $r->loadTemplate('debug.html');
                    });
        });
        $html = $r->apply($binds);
        print $html;
    }

}
