<?php


namespace Battis\Calendar\Properties\Component\Miscellaneous;


use Battis\Calendar\Parameter;
use Battis\Calendar\Property;

class NonStandardProperty extends Property
{
    /** @var string */
    private $name = null;

    /**
     * NonStandardProperty constructor.
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
