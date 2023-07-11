<?php

namespace App\Support;

use App\Router;

class Validation
{
    public static function changed($cur, $prev): bool
    {
        return $cur !== $prev;
    }

    public static function admin(): void
    {
        if (!(Session::get('is_admin') && Session::get('is_auth'))) {
            Router::redirect('/login');
        }
    }
}