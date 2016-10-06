<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class UserService extends Service {

    private $useCookies = false;
    private $useSessions = false;
    private $user = array(
        'id' => NULL,
        'authenticated' => false,
    );

    public function run() {

        if ($this->useCookies):
        // Check cookies
            $cookiesFound = false;
        endif;

        if ($this->useSessions):
        // Check sessions
        endif;
    }

    public function checkCookies() {
        
    }

    public function checkSessions() {
        
    }

    public function id() {
        return $this->user;
    }

}
