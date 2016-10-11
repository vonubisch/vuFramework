<?php

/**
 * Description of test
 *
 * @author bvubisch
 */
class ACLController extends Controller {

    public function run() {
        $this->dao = $this->dao('acl');
    }

    public function index() {
        $this->bind('groups', $this->dao->groups());
        $this->bind('routes', $this->dao->routesMatrix());
        $this->bind('members', $this->dao->members());
        $this->bind('users', $this->dao->users());
        $this->bind('actions', $this->dao->actionsMatrix());
        $this->bind('navigation', $this->dao('navigation')->getItems());
        $this->view('default')->acl($this->getBinds());
    }

    public function change() {
        switch ($this->parameter('table')):
            case 'action':
                switch ($this->parameter('type')):
                    case 'allow':
                        $this->dao->allowActionGroup(
                                $this->parameter('id'), $this->parameter('groupid')
                        );
                        break;
                    case 'deny':
                        $this->dao->denyActionGroup(
                                $this->parameter('id'), $this->parameter('groupid')
                        );
                        break;
                endswitch;
                break;
            case 'route':
                switch ($this->parameter('type')):
                    case 'allow':
                        $this->dao->allowRouteGroup(
                                $this->parameter('id'), $this->parameter('groupid')
                        );
                        break;
                    case 'deny':
                        $this->dao->denyRouteGroup(
                                $this->parameter('id'), $this->parameter('groupid')
                        );
                        break;
                endswitch;
                break;
        endswitch;
        $this->index();
    }

    public function sync() {
        $update = array('request', 'url', 'controller', 'method');
        foreach (Router::routes() as $key => $route):
            list($request, $url, $go, $name) = $route;
            list($controller, $method) = $go;
            $data = array(
                'name' => $name,
                'request' => $request,
                'url' => $url,
                'controller' => $controller,
                'method' => $method
            );
            $this->dao->sync($data, $update);
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
                $this->dao->addMember($data);
                break;
            case 'remove':
                $this->dao->removeMember($data);
                break;
        }
        $this->index();
    }

    public function route() {
        switch ($this->parameter('type')) {
            case 'remove':
                $this->dao->removeRoute(
                        $this->parameter('routeid')
                );
                break;
        }
        $this->index();
    }

    public function action() {
        switch ($this->parameter('type')) {
            case 'remove':
                $this->dao->removeAction(
                        $this->parameter('actionid')
                );
                break;
        }
        $this->index();
    }

}
