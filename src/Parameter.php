<?php


namespace Battis\Calendar;


use ArrayIterator;
use Battis\Calendar\Standards\RFC5545;

abstract class Parameter
{
    /** @var Value|Value[] */
    private $value;

    public function __construct(string $value = null)
    {
        $this->value = $value;
    }

    public function getName(): string
    {
        return array_search(get_class($this), RFC5545::PROPERTY_PARAMETERS);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getValueIterator(): ArrayIterator
    {
        if (is_array($this->value)) {
            return new ArrayIterator($this->value);
        }
        return null;
    }
}
