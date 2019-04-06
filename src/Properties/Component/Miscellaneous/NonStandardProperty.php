<?php


namespace Battis\Calendar\Properties\Component\Miscellaneous;


use Battis\Calendar\Exceptions\PropertyException;
use Battis\Calendar\Parameter;
use Battis\Calendar\Property;
use Battis\Calendar\Value;
use Battis\Calendar\Values\Text;

class NonStandardProperty extends Property
{
    /** @var string */
    private $name = null;

    /**
     * NonStandardProperty constructor.
     * @param string $name
     * @param Parameter[] $parameters
     * @param Value|Value[] $value
     * @throws PropertyException
     */
    public function __construct(string $name, array $parameters = [], $value = null)
    {
        $this->name = $name;
        parent::__construct($parameters, $value);
    }

    public function getName(): string
    {
        return strtoupper($this->name);
    }

    protected function autoboxPrimitives($value, bool $strict): Value
    {
        if ($value instanceof Value) {
            return $value;
        } else {
            return new Text($value, $strict);
        }
    }
}
