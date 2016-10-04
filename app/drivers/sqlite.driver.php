<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class SQLiteDriver extends Driver {

    public function run($options) {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $pdo = new PDO($options['dsn'], $options['user'], $options['password'], $opt);
        $this->dbh = $pdo;
    }

    public function handle() {
        return $this->dbh;
    }

}
