<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Value;

class Boolean extends Value
{
    public function __construct($value)
    {
        if (is_bool($value)) {
            parent::__construct($value);
        } elseif (strtoupper($value) == 'TRUE') {
            parent::__construct(true);
        } else {
            parent::__construct(false);
        }
    }

    public function __toString()
    {
        return ($this->value ? 'TRUE' : 'FALSE');
    }
}
