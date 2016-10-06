<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 * 
 * $this->database('name')              Get a database with driver handle
 */
class AuthenticationDAO extends DAO {

    public function run() {
        $this->dbh = $this->database('mysql');
    }

    public function readByUsername($username) {
        $sql = "SELECT `id`, `banned`, `language`, `username`, `password` FROM `users_accounts` WHERE `username` = :username LIMIT 1";
        return $this->dbh->query($sql)
                        ->bind(':username', $username)
                        ->fetch('obj');
    }

    public function readBySessionID($sessionid) {
        $sql = "SELECT `id`, `banned`, `language`, `username`, `password` FROM `users_accounts` WHERE `sessionid` = :sessionid LIMIT 1";
        return $this->dbh->query($sql)
                        ->bind(':sessionid', $sessionid)
                        ->fetch('obj');
    }

    public function updateSessionByUserID($id, $sessionid) {
        $this->dbh->table('users_accounts')
                ->update(array('sessionid' => $sessionid, 'active' => time()), "`id` = :id LIMIT 1")
                ->bind(':id', $id)
                ->execute();
        return $this->dbh->affected();
    }

    public function updateSessionBySessionID($id, $sessionid) {
        $this->dbh->table('users_accounts')
                ->update(array('sessionid' => $sessionid), "`sessionid` = :id LIMIT 1")
                ->bind(':id', $id)
                ->execute();
        return $this->dbh->affected();
    }

}
