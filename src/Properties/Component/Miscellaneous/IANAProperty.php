<?php


namespace Battis\Calendar\Properties\Component\Miscellaneous;


use Battis\Calendar\Parameter;
use Battis\Calendar\Property;
use Battis\Calendar\Value;

class IANAProperty extends Property
{
    /** @var string */
    private $name = null;

    /**
     * IANAProperty constructor.
     * @param string $name
     * @param Parameter[] $parameters
     * @param Value|Value[] $value
     */
    public function __construct(string $name, array $parameters = [], $value = null)
    {
        parent::__construct($parameters, $value);
        $this->name = $name;
    }

    public function getName(): string
    {
        return strtoupper($this->name);
    }
}
