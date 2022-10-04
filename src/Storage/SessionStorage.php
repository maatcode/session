<?php

namespace Maatcode\Session\Storage;

class SessionStorage
{
    protected string $sessionName;

    public function __construct($sessionName)
    {
        if ( static::isSessionStarted() === FALSE ) session_start();
        $this->sessionName = $sessionName;
        $this->initSession();
    }

    protected function initSession() {
        if (!isset($_SESSION[$this->sessionName])){
            $_SESSION[$this->sessionName] = [];
        }
    }

    public function set($key, $value) : SessionStorage {
        if (isset($_SESSION[$this->sessionName])) {
            $_SESSION[$this->sessionName][$key] = $value;
        }
        return $this;
    }

    public function get($key) {
        return $_SESSION[$this->sessionName][$key] ?? null;
    }
    public function unset($key) {
        if (isset($_SESSION[$this->sessionName])) {
            unset($_SESSION[$this->sessionName][$key]);
        }
    }

    public function getSession($sessionName = null) {
        if ($sessionName) {
            return $_SESSION[$this->sessionName];
        }
        return $_SESSION;
    }

    private static function isSessionStarted()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE;
            } else {
                return !(session_id() === '');
            }
        }
        return FALSE;
    }

}
