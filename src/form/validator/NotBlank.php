<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form\validator;


use mheinzerling\commons\StringUtils;

class NotBlank extends Validator
{

    public function isValid($input): bool
    {
        if ($input == null) return false;
        if (is_string($input) && StringUtils::isBlank($input)) return false;
        return true;
    }
}