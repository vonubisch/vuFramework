<?php

abstract class DAO {

    abstract public function run();

    public final function model($name = NULL) {
        if (is_null($name)):
            return $this->model;
        endif;
        // @TODO: include model if not included
        $this->model = Configuration::classname(__FUNCTION__, $name);
        return $this;
    }

}
