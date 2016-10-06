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
                'url' => $this->url('home')
            ),
            array(
                'id' => 2,
                'title' => 'Test',
                'url' => $this->url('test', array('test' => 'yes'))
            ),
        );
    }

}
