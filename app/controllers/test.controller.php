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
        
    }

    public function index() {
        $this->view('test')->test(
                array(
                    'navigation' => $this->dao('test.navigation')->getItems(),
                    'articles' => array(array('title' => 'Test title 1', 'description' => 'BLABLABLA'), array('title' => 'Test title 2', 'description' => 'BLABsdffdsfLABLA'))
                )
        );
    }

}
