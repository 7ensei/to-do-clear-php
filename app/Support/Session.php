<?php

namespace App\Support;

class Session
{
    public static function get(string $key): mixed
    {
        session_start();
        return $_SESSION[$key];
    }

    public static function set(string $key, mixed $value): void
    {
        session_start();
        $_SESSION[$key] = $value;
    }

    public static function getOnce(string $key): mixed
    {
        session_start();
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $value;
    }

    public static function destroy(): void
    {
        session_start();
        session_destroy();
    }
}