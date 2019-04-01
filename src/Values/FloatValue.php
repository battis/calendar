<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Value;

class FloatValue extends Value
{
    public function __construct($value)
    {
        parent::__construct((float)$value);
    }
}
