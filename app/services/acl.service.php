<?php

/**
 * Description of 
 *
 * @author Bjorn
 */
class ACLService extends Service {

    private $access = false;
    private $userid = 0;
    private $route, $errorRoute = '';

    public function run() {
        $this->requires('authentication');
        $this->route = $this->getRoute();
        $this->errorRoute = $this->getErrorRoute();
        $this->userid = $this->getUserID();
        if ($this->denied($this->route, $this->userid)):
            $this->redirect($this->errorRoute, array('code' => 403));
        endif;
        $this->access = true;
    }

    public function access($route, $userid = NULL) {
        if (is_null($userid)):
            $userid = $this->getUserID();
        endif;
        return $this->isAllowed($route, $userid);
    }

    public function denied($route, $userid = NULL) {
        if (is_null($userid)):
            $userid = $this->getUserID();
        endif;
        return !$this->access($route, $userid);
    }

    public function can($action, $userid = NULL) { // actions
        if (is_null($userid)):
            $userid = $this->getUserID();
        endif;
        return $this->dao('acl')->action($action, $userid);
    }

    public function cannot($action, $userid = NULL) { // actions
        if (is_null($userid)):
            $userid = $this->getUserID();
        endif;
        return !$this->can($action, $userid);
    }

    private function isAllowed($route, $userid) {
        return $this->dao('acl')->isAllowed($route, $userid);
    }

    private function getRoute() {
        return Configuration::read('route.name');
    }

    private function getErrorRoute() {
        return Configuration::read('enviroment.errorroute');
    }

    private function getUserID() {
        return $this->service('authentication')->id();
    }

}
