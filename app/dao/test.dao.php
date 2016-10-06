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
    
    private $mysql;

    public function run() {
        $this->mysql = $this->database('mysql');
    }

    public function test() {
        $dbh = $this->database('mysql');
        $cache = $this->database('cache');
        $cache->eraseExpired();
        $key = 'test';
        if (!$cache->isCached($key)):
            $sql = "SELECT * FROM `users_accounts` ORDER BY `id` ASC";
            $result = $dbh->query($sql)->fetchAll('class', $this->modelName());
            $cache->store($key, $result, 10);
        else:
            $result = $cache->retrieve($key);
        endif;
        return array('id' => 1, 'name' => 'bjorn');
    }

}
