<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;

class NotFoundException extends \Exception
{
    public function __construct($request)
    {
        parent::__construct("Resource not found >" . $request . "<", 404, null);
    }
}