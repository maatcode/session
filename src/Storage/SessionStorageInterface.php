<?php
declare(strict_types=1);

namespace Maatcode\Session\Storage;

interface SessionStorageInterface
{
    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value): SessionStorage;

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key): mixed;

    /**
     * @param $key
     * @return void
     */
    public function unset($key): void;

    /**
     * @param $sessionName
     * @return array|mixed
     */
    public function getSession($sessionName = null): mixed;
}
