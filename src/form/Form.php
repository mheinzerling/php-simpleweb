<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form;


use mheinzerling\simpleweb\form\input\Input;
use mheinzerling\simpleweb\message\SimpleRequest;

class Form
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Input[]
     */
    private $inputs = [];
    /**
     * @var bool
     */
    private $submitted = false;

    function __construct(string $name, array $inputs)
    {
        $this->name = $name;
        $this->inputs = $inputs;
    }

    public function getName()
    {
        return $this->name;
    }

    public function handle(callable $onValid)
    {
        if ($this->isSubmitted()) throw new \Exception("Called handle() twice");
        if (SimpleRequest::hasPost($this->getName())) {
            $this->submitted = true;
            foreach ($this->inputs as $input) {
                $input->handle();
            }
            if ($this->isValid()) {
                $data = [];
                foreach ($this->inputs as $key => $input) {
                    $data[$key] = $input->getValue();
                }
                $onValid($data);
            }
        }
    }

    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    public function isValid(): bool
    {
        foreach ($this->inputs as $input) {
            if ($input->hasErrors()) return false;
        }
        return true;
    }


    public function getValue(string $name)
    {
        return $this->inputs[$name]->getValue();
    }

    public function getInputValue(string $name): ?string
    {
        return $this->inputs[$name]->getInputValue();
    }

    public function hasErrors(string $name): bool
    {
        return $this->inputs[$name]->hasErrors();
    }

}