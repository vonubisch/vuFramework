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
        $this->model = Factory::model($name);
        return $this;
    }

    public final function modelName() {
        return get_class($this->model());
    }

    public final function database($name) {
        return Databases::connect($name);
    }

}
