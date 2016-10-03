<?php

class TestController extends Controller {

    public function run() {
        Debug::dump('Test Controller method RUN');
    }

    public function index() {
        Debug::dump('Test Controller method INDEX');
        Debug::dump($this->service('test')->test());
        Debug::dump($this->parameter('test'));
        Debug::dump($this->url('error'));
        $this->controller('test.test2', 'index');



        $this->view('test')->test(array('lol1', 'lol2'));
    }

}
