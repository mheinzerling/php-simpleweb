<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form\input;


class TextInput extends Input
{

    public function __construct($name)
    {
        parent::__construct($name);
    }

    protected function convertInput(string $inputValue)
    {
        return $inputValue;
    }
}