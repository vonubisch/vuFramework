<?php

class TestController extends Controller {

    public function run() {
        Debug::dump('Test Controller method RUN');
        $this->helper('sanitize');
        Debug::dump('Sanitizing... ' . Sanitize::slug('Lol lol lol loooool!!'));
    }

    public function index() {
        Debug::dump('Test Controller method INDEX');
        Debug::dump($this->service('test')->test());
        Debug::dump($this->parameter('test'));
        Debug::dump($this->url('error'));
        $this->controller('test.test2', 'index');

        Debug::dump($this->model('test', $this->dao('test')->test()));

        Debug::dump($this->dao('test')->model('test'));

        $this->view('test')->test(array('lol1', 'lol2'));
    }

}
