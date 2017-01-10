<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\form\input;


class SelectInput extends Input
{

    /**
     *
     * @var string[]
     */
    private $options;
    /**
     * @var array
     */
    private $values;

    public function __construct($name, array $options, array $values = null)
    {
        parent::__construct($name);
        $this->options = $options;
        $this->values = $values == null ? $options : $values;
    }

    protected function convertInput(string $inputValue)
    {
        return $this->values[$inputValue];
    }
}