<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 * 
 * $this->database('name')              Get a database with driver handle
 */
class TestDAO extends DAO {

    public function run() {
        
    }

    public function test() {


        Debug::dump('Is model loaded in DAO?...');
        Debug::dump($this->model());

        $dbh = $this->database('mysql');
        Debug::dump($dbh);

        $cache = $this->database('cache');
        $cache->eraseExpired();

        $key = 'test';
        if (!$cache->isCached($key)):
            $sql = "SELECT * FROM `users_accounts` ORDER BY `id` ASC";
            $result = $dbh->query($sql)->fetchAll('class', $this->modelName());
            $cache->store($key, $result, 10);
            Debug::dump('Getting from database...');
        else:
            Debug::dump('Retrieving from cache');
            $result = $cache->retrieve($key);
        endif;

        Debug::dump($result);

        return array('id' => 1, 'name' => 'bjorn');
    }

}