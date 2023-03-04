<?php
declare(strict_types=1);

namespace Maatcode\Session\Storage;

class SessionStorage implements SessionStorageInterface
{
    /**
     * @var string
     */
    protected string $sessionName;

    /**
     * @param $sessionName
     */
    public function __construct($sessionName)
    {
        if (static::isSessionStarted() === false) session_start();
        $this->sessionName = $sessionName;
        $this->initSession();
    }

    /**
     * @return void
     */
    protected function initSession(): void
    {
        if (!isset($_SESSION[$this->sessionName]))
        {
            $_SESSION[$this->sessionName] = [];
        }
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value): SessionStorage
    {
        if (isset($_SESSION[$this->sessionName]))
        {
            $_SESSION[$this->sessionName][$key] = $value;
        }
        return $this;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key): mixed
    {
        return $_SESSION[$this->sessionName][$key] ?? null;
    }

    /**
     * @param $key
     * @return void
     */
    public function unset($key): void
    {
        if (isset($_SESSION[$this->sessionName]))
        {
            unset($_SESSION[$this->sessionName][$key]);
        }
    }

    /**
     * @param $sessionName
     * @return array|mixed
     */
    public function getSession($sessionName = null): mixed
    {
        if ($sessionName)
        {
            return $_SESSION[$this->sessionName];
        }
        return $_SESSION;
    }

    /**
     * @return bool
     */
    private static function isSessionStarted(): bool
    {
        if (php_sapi_name() !== 'cli')
        {
            if (version_compare(phpversion(), '5.4.0', '>='))
            {
                return session_status() === PHP_SESSION_ACTIVE;
            }
            else
            {
                return !(session_id() === '');
            }
        }
        return false;
    }

}
