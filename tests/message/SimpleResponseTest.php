<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;

use mheinzerling\simpleweb\message\SimpleResponse;
use mheinzerling\simpleweb\message\Status;

class SimpleResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testToStatusCode()
    {
        $class = new \ReflectionClass(SimpleResponse::class);
        $method = $class->getMethod("toStatusCode");
        $method->setAccessible(true);

        static::assertEquals(302, $method->invokeArgs(null, [true]));
        static::assertEquals(301, $method->invokeArgs(null, [false]));
    }

    public function testToStatusHeader()
    {
        $class = new \ReflectionClass(SimpleResponse::class);
        $method = $class->getMethod("toStatusHeader");
        $method->setAccessible(true);

        $_SERVER['SERVER_PROTOCOL'] = "HTTP/1.1";

        static::assertEquals("HTTP/1.1 200 OK", $method->invokeArgs(null, [Status::OK()]));
        static::assertEquals("HTTP/1.1 301 Moved Permanently", $method->invokeArgs(null, [Status::Moved_Permanently()]));
        static::assertEquals("HTTP/1.1 302 Found", $method->invokeArgs(null, [Status::Found()]));
        static::assertEquals("HTTP/1.1 403 Forbidden", $method->invokeArgs(null, [Status::Forbidden()]));
        static::assertEquals("HTTP/1.1 404 Not Found", $method->invokeArgs(null, [Status::Not_Found()]));
        static::assertEquals("HTTP/1.1 500 Internal Server Error", $method->invokeArgs(null, [Status::Internal_Server_Error()]));
    }

}
