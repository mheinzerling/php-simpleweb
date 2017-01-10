<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form\validator;


abstract class Validator
{
    public abstract function isValid($input): bool;
}