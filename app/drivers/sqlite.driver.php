<?php

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
