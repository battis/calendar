<?php


namespace Battis\Calendar;


use ArrayIterator;
use Battis\Calendar\Exceptions\PropertyException;
use Battis\Calendar\Standards\RFC5545;
use Battis\Calendar\Values\Text;

abstract class Property
{
    /** @var Parameter[] */
    private $parameters = [];

    /** @var Value */
    private $value = null;

    /**
     * Property constructor.
     * @param Parameter[] $parameters
     * @param Value|Value[] $value
     */
    public function __construct(array $parameters = [], $value = null)
    {
        $this->parameters = $parameters;
        $this->value = $value;
    }

    /**
     * @param mixed $value
     * @param bool $strict
     * @return Value
     * @throws PropertyException
     */
    public function setValue($value, bool $strict = false): Value
    {
        $previousValue = $this->value;
        if (!($value instanceof Value)) {
            if (is_array($valueType = RFC5545::PROPERTY_VALUES[$this->getName()])) {
                foreach ($valueType as $type) {
                    if (preg_match('/^' . RFC5545::PROPERTY_VALUE_DATA_TYPES[$type] . '$/', $value) === 1) {
                        $value = new $type($value, $strict);
                    }
                }
                $value = new Text($value, $strict);
            }
            $value = new $valueType($value, $strict);
        }
        if ($strict) {
            $validValues = RFC5545::PROPERTY_VALUES[$this->getName()];
            if (!(get_class($value) !== $validValues || is_array($validValues) && in_array(get_class($value), $validValues))) {
                throw new PropertyException(basename(get_class($value)) . ' is not a valid value type for ' . basename(get_class($this)));
            }
        }
        $this->value = $value;
        return $previousValue;
    }

    public function getValue(): Value
    {
        return $this->value;
    }

    public function getName(): string
    {
        return array_search(get_class($this), RFC5545::PROPERTIES) ||
            'X-' . strtoupper(basename(get_class($this)));
    }

    public function getParametersIterator(): ArrayIterator
    {
        return new ArrayIterator($this->parameters);
    }
}
