<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\message;


class SimpleResponse
{
    public static function redirect(string $location, bool $temporarily): void
    {
        header("Location: " . $location, true, ($temporarily ? Status::Found() : Status::Moved_Permanently())->value());
        die();
    }

    public static function status(Status $status): void
    {
        $code = $status->value();
        $message = str_replace("_", " ", $status->key());
        header($_SERVER['SERVER_PROTOCOL'] . " " . $code . " " . $message, true);
    }
}