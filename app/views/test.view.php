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

    public function test() {
        Debug::dump('View->test() loaded');
    }

}
