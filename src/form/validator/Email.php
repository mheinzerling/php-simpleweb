<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form\validator;


class Email extends Validator
{

    public function isValid($input): bool
    {
        if (empty($input)) return true;
        return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}