<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;

class SimpleRouterTest extends \PHPUnit_Framework_TestCase
{
    public static $rendered;

    public function testRequest()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        static::assertEquals("index.php", $router->getRequest());
    }

    public function testRequestNoContext()
    {
        $router = new SimpleRouter("/context/", "/foo/index.php?foo=bar");
        static::assertEquals("/foo/index.php", $router->getRequest());
    }

    public function testResource()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        static::assertEquals("/context/css/style.css", $router->resource("css/style.css"));
    }

    public function testResourceAbsolute()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        try {
            $router->resource("/css/style.css");
            static::fail("Exception expected");
        } catch (\Exception $e) {
            static::assertEquals("Relative resource path to context expected.", $e->getMessage());
        }
    }

    public function testRouteSimple()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        SimpleRouterTest::$rendered = false;
        $router->add("index.php", new class extends Page
        {
            public function render(SimpleRouter $router): void
            {
                SimpleRouterTest::$rendered = true;
            }

            public function getIdentifier(): string
            {
                return "xxx";
            }
        });
        $router->handle();
        static::assertTrue(SimpleRouterTest::$rendered);
    }

    public function testRouteSimpleDenied()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        SimpleRouterTest::$rendered = false;
        $router->add("index.php", new class extends Page
        {

            public function render(SimpleRouter $router): void
            {
                SimpleRouterTest::$rendered = true;
            }

            public function getIdentifier(): string
            {
                return "xxx";
            }

            public function accessAllowed(): bool
            {
                return false;
            }
        });
        try {
            $router->handle();
            static::fail("Exception expected");
        } catch (ForbiddenException $e) {
            static::assertEquals("Forbidden page access >xxx<", $e->getMessage());
        }

        static::assertFalse(SimpleRouterTest::$rendered);
    }

    public function testRoutePattern()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        SimpleRouterTest::$rendered = false;
        $router->addPattern("@^i.*$@", new class extends Page
        {
            public function render(SimpleRouter $router): void
            {
                SimpleRouterTest::$rendered = true;
            }

            public function getIdentifier(): string
            {
                return "xxx";
            }
        });
        $router->handle();
        static::assertTrue(SimpleRouterTest::$rendered);
    }

    public function testRoutePatternDenied()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        SimpleRouterTest::$rendered = false;
        $router->addPattern("@^i.*$@", new class extends Page
        {

            public function render(SimpleRouter $router): void
            {
                SimpleRouterTest::$rendered = true;
            }

            public function getIdentifier(): string
            {
                return "xxx";
            }

            public function accessAllowed(): bool
            {
                return false;
            }
        });
        try {
            $router->handle();
            static::fail("Exception expected");
        } catch (ForbiddenException $e) {
            static::assertEquals("Forbidden page access >xxx<", $e->getMessage());
        }

        static::assertFalse(SimpleRouterTest::$rendered);
    }

    public function testRouteNotFound()
    {
        $router = new SimpleRouter("/context/", "/context/index.php?foo=bar");
        SimpleRouterTest::$rendered = false;
        try {
            $router->handle();
            static::fail("Exception expected");
        } catch (NotFoundException $e) {
            static::assertEquals("Resource not found >index.php<", $e->getMessage());
        }

        static::assertFalse(SimpleRouterTest::$rendered);
    }
}
