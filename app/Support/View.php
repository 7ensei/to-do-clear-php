<?php

namespace App\Support;

class View
{
    public static function render(mixed $var): string
    {
        return htmlspecialchars((string)$var);
    }
}