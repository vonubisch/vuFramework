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

    public function __call($name, $binds) {
        $this->setHeader('Content-Type', 'utf8');
        $variables = $binds[0];
        $variables['app'] = Configuration::readAll();
        $variables['user'] = $this->service('authentication')->user();
        $r = $this->renderer('templates');
        $r->layout('layouts/layout.html', function() use ($r, $name) {
            return $r->container('containers/container.html', function() use ($r, $name) {
                        return $r->loadTemplate('navigation.html') .
                                $r->loadTemplate($name . '.html') .
                                $r->loadTemplate('debug.html');
                    });
        });
        $html = $r->apply($variables);
        print $html;
    }

}
