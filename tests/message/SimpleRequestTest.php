<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;

use mheinzerling\simpleweb\message\SimpleRequest;

class SimpleRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        static::assertEquals(null, SimpleRequest::get("foo", null));
        static::assertEquals("bar", SimpleRequest::get("foo", "bar"));
        static::assertFalse(SimpleRequest::hasGet("foo"));
        $_GET['foo'] = "xxx";
        static::assertEquals("xxx", SimpleRequest::get("foo", null));
        static::assertEquals("xxx", SimpleRequest::get("foo", "bar"));
        static::assertTrue(SimpleRequest::hasGet("foo"));
    }

    public function testPost()
    {
        static::assertEquals(null, SimpleRequest::post("foo", null));
        static::assertEquals("bar", SimpleRequest::post("foo", "bar"));
        static::assertFalse(SimpleRequest::hasPost("foo"));
        $_POST['foo'] = "xxx";
        static::assertEquals("xxx", SimpleRequest::post("foo", null));
        static::assertEquals("xxx", SimpleRequest::post("foo", "bar"));
        static::assertTrue(SimpleRequest::hasPost("foo"));
    }
}
