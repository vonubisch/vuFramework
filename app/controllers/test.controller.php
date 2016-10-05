<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 * 
 * $this->helper('name')                Includes helper file
 * $this->service('name')               Access a service object
 * $this->parameter('name')             Get named parameter value from URL
 * $this->query('name')                 Get query value from URL
 * $this->url('route')                  Generate URL string from route name
 * $this->model('name',[*])             Returns a Model object, set properties optional
 * $this->dao('name')->model('name')    Returns a Data Access Object and set a optional Model(name)
 * $this->view('name')->test([*])       Initiates a View object to call with parameters
 */
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

        //Debug::dump($this->model('test', $this->dao('test')->test()));

        Debug::dump($this->dao('test')->model('test')->test());

        $this->view('test')->test(
                array(
                    'app' => array('sitename' => 'vuFramework layout'),
                    'navigation' => array(array('title' => 'Link one', 'url' => 'http://www.google1.nl'), array('title' => 'Link two', 'url' => 'http://www.google2.nl')),
                    'articles' => array(array('title' => 'Test title 1', 'description' => 'BLABLABLA'), array('title' => 'Test title 2', 'description' => 'BLABsdffdsfLABLA'))
                )
        );
    }

}
