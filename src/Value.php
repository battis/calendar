<?php


namespace Battis\Calendar;


use Battis\Calendar\Exceptions\ValueException;
use Battis\Calendar\Standards\RFC5545;

abstract class Value
{
    private $value;
    private $rawValue;

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
        if ($type = array_search(get_class($this), RFC5545::VALUES)) {
            return $type;
        } else {
            return strtoupper(basename(get_class($this)));
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @throws ValueException
     */
    protected function validate($value): void
    {
        if (preg_match('/^' . RFC5545::PROPERTY_VALUE_DATA_TYPES[get_class($this)] . '$/i', $value) !== 1) {
            throw new ValueException("`$value` does not match expected data type for " . basename(get_class($this)));
        }
    }

    /**
     * @param mixed $value
     * @param bool $strict Optional (default: `false`)
     * @param mixed $rawValue (Optional, default `null`)
     * @return mixed
     * @throws ValueException
     */
    public function setValue($value, bool $strict = false, $rawValue = null)
    {
        $previousValue = $this->value;
        if ($strict) {
            if ($rawValue !== null) {
                $this->validate($rawValue);
            } else {
                $this->validate($value);
            }
        }
        $this->value = $value;
        $this->rawValue = $rawValue;
        return $previousValue;
    }

    public function getRawValue()
    {
        return $this->rawValue;
    }

    public function __toString()
    {
        if (is_array($this->value)) {
            return implode(
                RFC5545::FIELD_SEPARATOR,
                array_map(
                    function ($field, $value) {
                        return $field . RFC5545::PARAMETER_KEYVALUE_SEPARATOR . $value;
                    },
                    array_keys($this->value),
                    array_values($this->value)
                )
            );
        }
        return (string)$this->value;
    }
}
