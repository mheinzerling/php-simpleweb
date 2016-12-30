<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\message;

/**
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class SimpleRequest
{
    public static function get(string $key, string $def = null): ?string
    {
        if (self::hasGet($key)) return $_GET[$key];
        return $def;
    }

    public static function post(string $key, string $def = null): ?string
    {
        if (self::hasPost($key)) return $_POST[$key];
        return $def;
    }

    public static function hasGet(string $key): bool
    {
        return isset($_GET[$key]);
    }

    public static function hasPost(string $key): bool
    {
        return isset($_POST[$key]);
    }
}