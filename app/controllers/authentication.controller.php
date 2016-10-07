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
class AuthenticationController extends Controller {

    public function run() {
        
    }

    public function login() {
        if ($this->request('post')):
            $this->service('authentication')
                    ->logout();
            $this->service('authentication')
                    ->login($this->post('username'), $this->post('password'));
        endif;
        $this->bind('navigation', $this->dao('navigation')->getItems());
        $this->view('default')->login($this->getBinds());
    }

    public function logout() {
        $this->service('authentication')
                ->logout();
        $this->redirect();
    }

}
