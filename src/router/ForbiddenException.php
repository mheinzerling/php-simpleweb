<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;

class ForbiddenException extends \Exception
{
    public function __construct(Page $page)
    {
        parent::__construct("Forbidden page access >" . $page->getIdentifier() . "<", 403, null);
    }
}