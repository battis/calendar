<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Value;

class Integer extends Value
{
    public function setValue($value, bool $strict = false, $rawValue = null)
    {
        if ($rawValue === null) {
            $rawValue = $value;
        }
        return parent::setValue((int)$value, $strict, $rawValue);
    }
}
