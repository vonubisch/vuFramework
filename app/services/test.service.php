<?php

class TestService extends Service {
    
    public function run() {
        Debug::dump('Test Service method RUN');
    }
    
    public function test() {
        return 'Testing TestService method test';
    }
}
