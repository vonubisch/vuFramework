<?php

/**
 * @package    vuFramework
 * @version    v8.0
 * @author     Bjorn Stefan von Ubisch <bs@vonubisch.com>
 * @copyright  2016 vonUbisch.com
 */
class Cookie {

    const Session = null;
    const oneday = 86400;
    const sevendays = 604800;
    const thirtydays = 2592000;
    const sixmonths = 15811200;
    const oneyear = 31536000;
    const lifetime = -1; // 2030-01-01 00:00:00

    /**
     * Returns true if there is a cookie with this name.
     *
     * @param string $name
     * @return bool
     */

    static public function exist($name) {
        return isset($_COOKIE[$name]);
    }

    /**
     * Returns true if there no cookie with this name or it's empty, or 0,
     * or a few other things. Check http://php.net/empty for a full list.
     *
     * @param string $name
     * @return bool
     */
    static public function IsEmpty($name) {
        return empty($_COOKIE[$name]);
    }

    /**
     * Get the value of the given cookie. If the cookie does not exist the value
     * of $default will be returned.
     *
     * @param string $name
     * @param string $default
     * @return mixed
     */
    static public function read($name, $default = '') {
        return (isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default);
    }

    /**
     * Set a cookie. Silently does nothing if headers have already been sent.
     *
     * @param string $name
     * @param string $value
     * @param mixed $expiry
     * @param string $path
     * @param string $domain
     * @return bool
     */
    static public function write($name, $value, $expiry = self::oneyear, $path = '/', $domain = NULL) {
        $retval = false;
        if (headers_sent()):
            return $retval;
        endif;
        if ($expiry === -1):
            $expiry = 1893456000; // Lifetime = 2030-01-01 00:00:00
        elseif (is_numeric($expiry)):
            $expiry += time();
        else:
            $expiry = strtotime($expiry);
        endif;
        $retval = setcookie($name, $value, $expiry, $path, $domain);
        if ($retval):
            $_COOKIE[$name] = $value;
        endif;
        return $retval;
    }

    /**
     * Delete a cookie.
     *
     * @param string $name
     * @param string $path
     * @param string $domain
     * @param bool $remove_from_global Set to true to remove this cookie from this request.
     * @return bool
     */
    static public function destroy($name, $path = '/', $domain = NULL, $remove_from_global = false) {
        $retval = false;
        if (headers_sent()):
            return $retval;
        endif;
        if ($domain === false):
            $domain = $_SERVER['HTTP_HOST'];
        endif;
        $retval = setcookie($name, '', 1, $path, $domain);
        if ($remove_from_global):
            unset($_COOKIE[$name]);
        endif;
        return $retval;
    }

}
