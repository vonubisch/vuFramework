<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 * http://twig.sensiolabs.org/doc/templates.html
 * http://twig.sensiolabs.org/doc/api.html
 */
class TwigRenderer extends Renderer {

    public function run($options) {
        $this->twig = $this->getTwig();
    }

    public function template($name) {
        return $this->twig->loadTemplate($name);
    }

    public function render($template, $binds = array()) {
        return $this->twig->render($template, $binds);
    }

    private function getTwig() {
        $this->library('twig/Autoloader.php');
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem(str_replace(Configuration::read('magic.replace'), '', Configuration::read('paths.public')));
        return new Twig_Environment($this->loader, array(
            'cache' => str_replace(Configuration::read('magic.replace'), 'twig' . DIRECTORY_SEPARATOR, Configuration::read('paths.cache')),
        ));
    }

    private function getFile($file) {
        $path = $this->path($file);
        if (!file_exists($path)):
            throw new RendererException(Exceptions::FILENOTFOUND . $file);
        endif;
        return file_get_contents($path);
    }

    private function path($file) {
        return Configuration::path('public', $file);
    }

}
