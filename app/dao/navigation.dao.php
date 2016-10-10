<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 * 
 * $this->database('name')              Get a database with driver handle
 */
class NavigationDAO extends DAO {

    public function run() {
        
    }

    public function getItems() {
        return array(
            array(
                'id' => 1,
                'title' => 'Home',
                'url' => $this->url('home'),
                'submenu' => false
            ),
            array(
                'id' => 2,
                'title' => 'Login',
                'url' => $this->url('login'),
                'submenu' => false
            ),
            array(
                'id' => 3,
                'title' => 'Logout',
                'url' => $this->url('logout'),
                'submenu' => false
            ),
            array(
                'id' => 4,
                'title' => 'ACL',
                'url' => $this->url('acl'),
                'submenu' => false
            ),
            array(
                'id' => 5,
                'title' => 'Test',
                'url' => $this->url('test', array('test' => 'yes')),
                'submenu' => array(
                    array(
                        'id' => 1,
                        'title' => 'Test 1',
                        'url' => $this->url('test', array('test' => 'yes'))
                    ),
                    array(
                        'id' => 2,
                        'title' => 'Trigger 404',
                        'url' => 'dddd'
                    ),
                )
            ),
        );
    }

}
