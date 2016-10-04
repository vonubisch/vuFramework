<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class TestService extends Service {

    public function run() {
        Debug::dump('Test Service method RUN');
    }

    public function test() {
        return 'Testing TestService method test';
    }

}
