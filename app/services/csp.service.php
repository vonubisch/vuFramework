<?php

/**
 * Description of 
 *
 * @author Bjorn
 */
class CSPService extends Service {

    public $app;
    private $rules = array();

    public function run() {
        $headers = '';
        $rules = Configuration::read('enviroment.csp');
        foreach ($rules as $key => $value):
            $headers .= "{$key} {$value}; ";
        endforeach;
        foreach (array("X-WebKit-CSP", "X-Content-Security-Policy", "Content-Security-Policy") as $csp) {
            $this->headers($csp, $headers);
        }
        $this->rules = $rules;
    }

}
