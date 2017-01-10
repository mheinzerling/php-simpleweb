<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form;


use mheinzerling\simpleweb\form\input\Input;
use mheinzerling\simpleweb\form\input\SelectInput;
use mheinzerling\simpleweb\form\input\TextInput;
use mheinzerling\simpleweb\form\validator\Email;

class FormBuilder
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
     * @var
     */
    private $lastInput;

    function __construct(string $name)
    {
        $this->name = $name;
    }

    public function select($name, array $options, array $secret = null): FormBuilder
    {
        $this->inputs[$name] = new SelectInput($name, $options, $secret);
        $this->lastInput = $name;
        return $this;
    }

    public function text($name): FormBuilder
    {
        $this->inputs[$name] = new TextInput($name);
        $this->lastInput = $name;
        return $this;
    }


    public function email($name): FormBuilder
    {
        $this->inputs[$name] = new TextInput($name);
        $this->inputs[$name]->addValidator(new Email());
        $this->lastInput = $name;
        return $this;
    }

    public function required(): FormBuilder
    {
        $this->inputs[$this->lastInput]->required();
        return $this;
    }

    public function build()
    {
        return new Form($this->name, $this->inputs);
    }

}