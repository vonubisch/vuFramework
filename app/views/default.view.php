<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class DefaultView extends View {

    public function run() {
        
    }

    public function __call($name, $binds) {
        $this->setHeader('Content-Type', 'utf8');
        $twig = $this->renderer('twig');
        echo $twig->render($name . '.twig', $binds[0]);
    }

}
