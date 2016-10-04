<?php

class MySQLDriver extends Driver {

    public $dbh;
    private $stmt, $table;
    private $_parameters = array();
    private $fetchtype = PDO::FETCH_ASSOC;
    private $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    public function run($options) {
        if (empty($options['dsn']) || empty($options['user'])) {
            throw new DriverException('Database credentials not properly set');
        }
        try {
            $this->dbh = new PDO($options['dsn'], $options['user'], $options['password'], $this->options);
        } catch (PDOException $e) {
            throw new DriverException($e->getMessage());
        }
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }

    public function insert(array $data, $duplicate = false) {
        $this->_parameters = array();
        $fields = array_keys($data);
        $sql = 'INSERT INTO `' . $this->table . '` (' . implode($fields, ', ') . ') VALUES (:create_' . implode($fields, ", :create_") . ')';
        if ($duplicate) {
            $fields = $this->updateDuplicate($duplicate);
            $sql .= ' ON DUPLICATE KEY UPDATE ' . $fields;
        }
        $this->stmt = $this->dbh->prepare($sql);
        $this->bindArray($data, 'create');
        return $this;
    }

    public function updateDuplicate(array $fields) {
        $set = '';
        $count = count($fields);
        for ($i = 0; $i < $count; $i++) {
            $set .= $fields[$i] . ' = VALUES(' . $fields[$i] . ')';
            if ($i !== ($count - 1)) {
                $set .= ', ';
            }
        }
        return $set;
    }

    public function update(array $data, $where = '') {
        $fields = array_keys($data);
        $set = '';
        $count = count($fields);
        for ($i = 0; $i < $count; $i++) {
            $set .= $fields[$i] . ' = :update_' . $fields[$i];
            if ($i !== ($count - 1)) {
                $set .= ', ';
            }
        }
        if (!empty($where)) {
            $where = ' WHERE ' . $where;
        }
        $sql = 'UPDATE `' . $this->table . '` SET ' . $set . ' ' . $where;
        $this->stmt = $this->dbh->prepare($sql);
        $this->bindArray($data, 'update');
        return $this;
    }

    public function delete($where) {
        $sql = 'DELETE FROM `' . $this->table . '` WHERE ' . $where;
        $this->stmt = $this->dbh->prepare($sql);
        return $this;
    }

    // Empties table, and resets increment ID
    public function truncate($table) {
        $sql = 'TRUNCATE TABLE `' . $table . '`';
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute();
    }

    public function count($where = NULL, $data = array()) {
        $sql = "SELECT count(*) FROM `{$this->table}`";
        if (!is_null($where)):
            " WHERE " . $where;
        endif;
        $this->stmt = $this->dbh->prepare($sql);
        $this->bindArray($where, 'count');
        $row = $this->stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function bindArray(array $binds, $type = NULL) {
        if (!is_null($type)) {
            $type = $type . '_';
        }
        foreach ($binds as $k => $v) {
            $this->bind(':' . $type . $k, $v);
        }
        return $this;
    }

    public function query($query) {
        $this->_parameters = array();
        $this->stmt = $this->dbh->prepare($query);
        return $this;
    }

    public function bind($pos, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->_parameters[$pos] = $value;
        $this->stmt->bindParam($pos, $value, $type);
        return $this;
    }

    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            throw new DriverException($e->getMessage());
        }
    }

    public function fetch($type = NULL, $parameter = NULL) {
        return $this->_fetchType(__FUNCTION__, $type, $parameter);
    }

    public function fetchAll($type = NULL, $parameter = NULL) {
        return $this->_fetchType(__FUNCTION__, $type, $parameter);
    }

    public function affected() {
        return $this->stmt->rowCount();
    }

    public function id() {
        return $this->dbh->lastInsertId();
    }

    private function _fetchType($function, $type = NULL, $parameter = NULL) {
        $this->execute();
        switch ($type):
            case 'obj':
                $this->stmt->setFetchMode(PDO::FETCH_OBJ);
                break;
            case 'class':
                if (is_null($parameter) || !class_exists($parameter)) {
                    throw new DriverException('Class for query not properly set');
                }
                $this->stmt->setFetchMode(PDO::FETCH_CLASS, $parameter);
                break;
            case 'assoc':
                $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
                break;
            case 'column':
                if (is_null($parameter)) {
                    throw new DriverException('Parameter for column not set');
                }
                $this->stmt->setFetchMode(PDO::FETCH_COLUMN, $parameter);
                break;
            case 'into':
                $this->stmt->setFetchMode(PDO::FETCH_INTO, $parameter);
                break;
            default:
                $this->stmt->setFetchMode($this->fetchtype);
        endswitch;
        return $this->stmt->{$function}();
    }

}
