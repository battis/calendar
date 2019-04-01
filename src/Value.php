<?php


namespace Battis\Calendar;


use Battis\Calendar\Exceptions\ValueException;
use Battis\Calendar\Standards\RFC5545;

abstract class Value
{
    private $value;

    /**
     * Value constructor.
     * @param mixed $value
     * @param bool $strict
     * @throws ValueException
     */
    public function __construct($value, bool $strict = false)
    {
        $this->setValue($value, $strict);
    }

    protected function getType(): string
    {
        return array_search(get_class($this), RFC5545::VALUES) ||
            strtoupper(basename(get_class($this)));
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @param bool $strict Optional (default: `false`)
     * @return Value|Value[]|null
     * @throws ValueException
     */
    public function setValue($value, bool $strict = false)
    {
        if ($strict && preg_match('/^' . RFC5545::PROPERTY_VALUE_DATA_TYPES[get_class($this)] . '$/i', $value) !== 1) {
            throw new ValueException("`$value` does not match expected data type for " . basename(get_class($this)));
        }
        $previousValue = $this->value;
        $this->value = $value;
        return $previousValue;
    }
}
