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
        $r = $this->renderer('templates');

        $r->layout('layouts/layout.html', function() use ($r) {
            return $r->loadTemplate('navigation.html') .
                    $r->loadTemplate('container.html');
        });
        $html = $r->apply($binds);
        Debug::dump(htmlentities($html));
        print $html;
    }

}
