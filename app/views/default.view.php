<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class DefaultView extends View {

    public function run() {
        
    }

    public function content($file, $binds) {
        $this->setHeader('Content-Type', 'utf8');
        $binds['app'] = Configuration::readAll();
        $binds['user'] = $this->service('user')->data();
        $r = $this->renderer('templates');
        $r->layout('layouts/layout.html', function() use ($r, $file) {
            return $r->container('containers/container.html', function() use ($r, $file) {
                        return $r->loadTemplate('navigation.html') .
                                $r->loadTemplate($file . '.html') .
                                $r->loadTemplate('debug.html');
                    });
        });
        $html = $r->apply($binds);
        print $html;
    }

}
