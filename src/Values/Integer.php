<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Value;

class Integer extends Value
{
    public function __construct($value)
    {
        parent::__construct((int)$value);
    }
}
