<?php
declare(strict_types=1);

namespace App;

/**
 * @method static void get(string $path, $controller, $method)
 * @method static void post(string $path, $controller, $method)
 */
class Router
{
    const GET = 'get';
    const POST = 'post';


    public static function __callStatic(string $name, array $args): void
    {
        $allowedMethod = match ($name) {
            Router::GET, Router::POST => true,
            default => false,
        };
        if (!$allowedMethod) return;

        [$url, $controller, $method] = $args;

        if (Router::getUrl() === $url && $_SERVER['REQUEST_METHOD'] === strtoupper($name)) {
            (new $controller())->$method();
        }
    }

    public static function getUrl(): string
    {
        return '/' . trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '/', (explode('?', $_SERVER['REQUEST_URI'])[0])), '/') ?: '/';
    }

    public static function generateUrl(string $url, array $params = []): string
    {
        $query = [];
        foreach ($params as $key => $value) {
            $query[] = $key . '=' . htmlspecialchars((string)$value);
        }
        $query = implode('&', $query);
        $url = trim($url, '/');
        $url = $query ? trim($url, '/') . '?' . $query : trim($url, '/');

        return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/' . $url;
    }

    public static function redirect(string $url, array $params = []): void
    {
        header("Location: " . Router::generateUrl($url, $params));
        die();
    }
}