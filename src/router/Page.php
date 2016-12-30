<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;

abstract class Page
{
    public abstract function render(SimpleRouter $router): void;

    public abstract function getIdentifier(): string;

    public function accessAllowed(): bool
    {
        return true;
    }
}