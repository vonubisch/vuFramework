<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
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

    public final function database($name) {
        return Databases::connect($name);
    }

}
