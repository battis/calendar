<?php


namespace Battis\Calendar\Parameters;


use Battis\Calendar\Parameter;

class IANAParameter extends Parameter
{
    /** @var string */
    private $name = null;

    public function __construct(string $name, string $value = null)
    {
        parent::__construct($value);
        $this->name = $name;
    }

    protected function getName(): string
    {
        return strtoupper($this->name);
    }
}
