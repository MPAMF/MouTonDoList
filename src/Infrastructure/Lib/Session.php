<?php

namespace App\Infrastructure\Lib;

class Session
{

    /**
     * Check if key exists in session
     *
     * @param string $key Key
     * @return bool $key exists in session
     */
    public static function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get a session value based on it's key.
     * this will return to false if the session specified is not set
     *
     * @param String $key session key to fetch: $_SESSION[$key]
     *
     * @return Mixed $_SESSION[$key] value or false if not set
     */
    public static function get(string $key): mixed
    {
        return static::exists($key) ? $_SESSION[$key] : false;
    }

    /**
     * Set a session
     *
     * @param String $key session key to be set: $_SESSION[$key]
     * @param Mixed $value session value to be set
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key session key to be unset: $_SESSION[$key]
     */
    public static function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

}