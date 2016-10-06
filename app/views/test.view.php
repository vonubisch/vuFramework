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
        Debug::dump($binds);
        $r = $this->renderer('templates');

        $r->layout('layouts/layout.html', function() use ($r) {
            return $r->container('containers/container.html', function() use ($r) {
                        return $r->loadTemplate('navigation.html');
                    });
        });
        $html = $r->apply($binds);
        Debug::dump(htmlentities($html));
        print $html;
    }

}
