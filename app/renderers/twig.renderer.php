<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 * http://twig.sensiolabs.org/doc/templates.html
 * http://twig.sensiolabs.org/doc/api.html
 */
function url($date_string, $format_string) {
    return print_r($date_string . $format_string);
}

class TwigRenderer extends Renderer {

    public function run($options) {
        $this->twig = $this->getTwig();
    }

    public function template($name) {
        return $this->twig->loadTemplate($name);
    }

    public function render($template, $binds = array()) {
        try {
            return $this->twig->render($template, $binds);
        } catch (Twig_Error $e) {
            throw new RendererException($e->getMessage());
        }
    }

    private function getTwig() {
        $this->library('twig/Autoloader.php');
        $this->library('twig-extensions/test.php');
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($this->path('public', ''));
        $twig = new Twig_Environment($this->loader, array(
            'debug' => $this->debugging()
                //'cache' => str_replace($this->path('cache', 'twig' . DIRECTORY_SEPERATOR)),
        ));
        $twig->addFunction($this->functionURL());
        $twig->addExtension(new Twig_Extension_Debug());
        return $twig;
    }

    private function functionURL() {
        return new Twig_SimpleFunction('url', function ($name) {
            $args = func_get_args();
            if (!isset($args[1])):
                $args = array();
            else:
                $args = $args[1];
            endif;
            return Router::generate($name, $args);
        });
    }

    private function debugging() {
        return Configuration::read('enviroment.errors');
    }

    private function path($type, $file) {
        return Configuration::path($type, $file);
    }

}
