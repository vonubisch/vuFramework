<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class AuthenticationService extends Service {

    private $useCookies = true;
    private $useSessions = true;
    private $key = 'vuauth';
    private $user = array(
        'id' => NULL,
        'name' => 'Guest',
        'authenticated' => false
    );

    public function run() {
        if (!$this->useCookies && !$this->useSessions):
            return;
        endif;
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
            return; // No sessions found in cookies or sessions
        endif;
        $user = $this->dao('authentication')->readBySessionID($sessionid);
        if (!$user):
            return; // Session ID not found
        endif;
        $this->setUser($user);
    }

    public function login($username, $password, $cookie = true) {
        if (!$this->useCookies && !$this->useSessions):
            return;
        endif;
        $this->logout();
        $user = $this->dao('authentication')->readByUsername($username);
        if (empty($user->id)) {
            return; // User not found
        }
        if (!$this->checkPassword($password, $user->password)):
            return; // Password does not match
        endif;
        $sessionid = Session::generateId();
        if (!$this->dao('authentication')->updateSessionByUserID($user->id, $sessionid)):
            return; // Updating sessionid failed
        endif;
        Session::write($this->key, $sessionid);
        if ($cookie):
            Cookie::write($this->key, $sessionid);
        endif;
        $user->sessionid = $sessionid;
        $this->setUser($user);
    }

    public function logout() {
        if (!Session::exist($this->key)):
            return false;
        endif;
        $this->dao('authentication')->updateSessionBySessionID(Session::read($this->key), '');
        Session::destroy($this->key);
        Cookie::destroy($this->key);
    }

    private function checkPassword($input, $stored) {
        $this->library('authentication/hasher.php');
        $hasher = new Hasher();
        return $hasher->CheckPassword($input, $stored);
    }

    private function setUser($user) {
        $this->user['id'] = $user->id;
        $this->user['name'] = $user->username;
        $this->user['authenticated'] = true;
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

    public function user() {
        return $this->user;
    }

}
