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
    private $key = 'vuauth';
    private $user = array(
        'id' => NULL,
        'id' => 'Guest',
        'authenticated' => false,
    );

    public function run() {
        $this->helper('cookie');
        $this->helper('session');
        $sessionid = NULL;
        if ($this->useCookies && Cookie::exist($this->key)):
            $sessionid = Cookie::read($this->key);
        endif;
        if ($this->useSessions && Session::exist($this->key)):
            $sessionid = Session::read($this->key);
        endif;
        if (is_null($sessionid)):
            return; // No sessions found
        endif;
        // Check if session matches
        $this->user['name'] = 'User';
        $this->user['authenticated'] = true;
    }

    public function checkCookies() {
        
    }

    public function checkSessions() {
        
    }

    public function id() {
        return $this->user['id'];
    }

    public function name() {
        return $this->user['name'];
    }

    public function authenticated() {
        return (bool) $this->user['authenticated'];
    }

    public function data() {
        return $this->user;
    }

}
