<?php

/**
 * Description of test
 *
 * @author bvubisch
 */
class ACLController extends Controller {

    public function run() {
        
    }

    public function index() {
        $acl = $this->dao('acl');
        $this->bind('groups', $acl->groups());
        $this->bind('routes', $acl->routes());
        $this->bind('navigation', $this->dao('navigation')->getItems());
        $this->view('default')->acl($this->binds());
    }

    public function change() {
        $acl = $this->dao('acl');
        switch ($this->parameter('type')):
            case 'allow':
                $acl->allowGroup(
                        $this->parameter('routeid'), $this->parameter('groupid')
                );
                break;
            case 'deny':
                $acl->denyGroup(
                        $this->parameter('routeid'), $this->parameter('groupid')
                );
                break;
        endswitch;
        $this->index();
    }

    public function sync() {
        $update = array('method', 'url', 'controller', 'action');
        foreach (Router::routes() as $key => $route):
            list($method, $url, $go, $name) = $route;
            list($controller, $action) = $go;
            $data = array(
                'name' => $name,
                'method' => $method,
                'url' => $url,
                'controller' => $controller,
                'action' => $action
            );
            $this->dao('acl')->sync($data, $update);
        endforeach;
        $this->index();
    }

    public function member() {
        $data = array(
            'userid' => $this->post('userid', FILTER_SANITIZE_NUMBER_INT),
            'groupid' => $this->parameter('groupid')
        );
        switch ($this->parameter('type')) {
            case 'add':
                $this->dao('acl')->addMember($data);
                break;
            case 'remove':
                $this->dao('acl')->removeMember($data);
                break;
        }
        $this->index();
    }

    public function route() {
        switch ($this->parameter('type')) {
            case 'remove':
                $this->dao('acl')->removeRoute(
                        $this->parameter('routeid')
                );
                break;
        }
        $this->index();
    }

}
