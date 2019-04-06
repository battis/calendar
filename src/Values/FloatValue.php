<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Value;

class FloatValue extends Value
{
    public function setValue($value, bool $strict = false, $rawValue = null)
    {
        if ($rawValue === null) {
            $rawValue = $value;
        }
        return parent::setValue((float)$value, $strict, $rawValue);
    }
}
