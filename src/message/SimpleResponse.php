<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\message;


class SimpleResponse
{
    /**
     * Last statement of a request.
     *
     * @param string $location
     * @param bool $temporarily
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public static function redirect(string $location, bool $temporarily): void
    {
        header("Location: " . $location, true, self::toStatusCode($temporarily));
        die();
    }

    private static function toStatusCode(bool $temporarily): int
    {
        $statusCode = ($temporarily ? Status::Found() : Status::Moved_Permanently())->value();
        return $statusCode;
    }

    public static function status(Status $status): void
    {
        header(self::toStatusHeader($status), true);
    }

    /**
     * @param Status $status
     * @return string
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private static function toStatusHeader(Status $status): string
    {
        return $_SERVER['SERVER_PROTOCOL'] . " " . $status->value() . " " . str_replace("_", " ", $status->key());
    }


}