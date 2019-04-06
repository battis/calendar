<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Exceptions\ValueException;
use Battis\Calendar\Value;

class Boolean extends Value
{
    protected function validate($value): void
    {
        if (!is_bool($value) || (strtoupper($value) != 'TRUE' && strtoupper($value) != 'FALSE')) {
            throw new ValueException('Must be a boolean value');
        }
    }

    public function setValue($value, bool $strict = false, $rawValue = null)
    {
        if ($rawValue === null) {
            $rawValue = $value;
        }
        return parent::setValue((bool)$value, $strict, $rawValue);
    }

    public function __toString()
    {
        return ($this->getValue() ? 'TRUE' : 'FALSE');
    }
}
