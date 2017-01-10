<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form\input;

use mheinzerling\simpleweb\form\validator\NotBlank;
use mheinzerling\simpleweb\form\validator\Validator;
use mheinzerling\simpleweb\message\SimpleRequest;

abstract class Input
{
    /**
     * @var Validator[]
     */

    private $validators = [];
    /**
     * @var mixed
     */
    private $value;
    /**
     * @var string
     */
    private $inputValue;
    /**
     * @var string[]
     */
    private $errors;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function required()
    {
        $this->addValidator(new NotBlank());
    }

    public function addValidator(Validator $validator)
    {
        $this->validators[] = $validator;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getInputValue(): ?string
    {
        return $this->inputValue;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function handle()
    {
        $this->inputValue = SimpleRequest::post($this->name);
        $this->errors = [];
        $this->value = $this->convertInput($this->inputValue);
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) $this->errors[] = $validator;
        }
        if ($this->hasErrors()) $this->value = null;
    }

    protected abstract function convertInput(string $inputValue);
}