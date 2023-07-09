<?php

namespace App\Support;

use App\Router;

class Validation
{
    public static function changed($cur, $prev): bool
    {
        return $cur !== $prev;
    }

    public static function authorized(): void
    {
        session_start();
        if (!$_SESSION['is_auth']) {
            Router::redirect('/login');
        }
    }

    public static function admin(): void
    {
        session_start();
        if (!$_SESSION['is_admin']) {
            Router::redirect('/login');
        }
    }
}