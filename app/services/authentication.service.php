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
        $sessionid = $this->getSessionID();
        if (!$this->getSessionID()):
            return; // No sessions found in cookies or sessions
        endif;
        $user = $this->readBySessionID($sessionid);
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
        $user = $this->readByUsername($username);
        if (!$user) {
            return; // User not found
        }
        if (!$this->checkPassword($password, $user->password)):
            return; // Password does not match
        endif;
        $sessionid = $this->generateID();
        if (!$this->updateSessionByUserID($user->id, $sessionid)):
            return; // Updating sessionid failed
        endif;
        $this->writeSession($this->key, $sessionid);
        if ($cookie):
            $this->writeCookie($this->key, $sessionid);
        endif;
        $this->setUser($user);
    }

    public function logout() {
        if (!$this->existSession($this->key)):
            return false;
        endif;
        $this->updateSessionBySessionID($this->readSession($this->key), '');
        $this->destroySession($this->key);
        $this->destroyCookie($this->key);
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

    private function getSessionID() {
        $sessionid = NULL;
        if ($this->useCookies && $this->existCookie($this->key)):
            $sessionid = $this->readCookie($this->key);
        endif;
        if ($this->useSessions && $this->existSession($this->key)):
            $sessionid = $this->readSession($this->key);
        endif;
        return $sessionid;
    }

    private function readBySessionID($sessionid) {
        return $this->dao('authentication')->readBySessionID($sessionid);
    }

    private function readByUsername($username) {
        return $this->dao('authentication')->readByUsername($username);
    }

    private function updateSessionByUserID($userid, $sessionid) {
        return $this->dao('authentication')->updateSessionByUserID($userid, $sessionid);
    }

    private function updateSessionBySessionID($sessionid, $empty) {
        return $this->dao('authentication')->updateSessionBySessionID($sessionid, $empty);
    }

    private function existCookie($key) {
        return Cookie::exist($key);
    }

    private function readCookie($key) {
        return Cookie::read($key);
    }

    private function writeCookie($key, $value) {
        return Cookie::write($key, $value);
    }

    private function destroyCookie($key) {
        return Cookie::destroy($key);
    }

    private function existSession($key) {
        return Session::exist($key);
    }

    private function readSession($key) {
        return Session::read($key);
    }

    private function writeSession($key, $value) {
        return Session::write($key, $value);
    }

    private function destroySession($key) {
        return Session::destroy($key);
    }

    private function generateID() {
        return Session::generateId();
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

}
