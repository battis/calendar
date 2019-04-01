<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Value;

class Binary extends Value
{
    public function __construct($value, bool $isPlainText = false)
    {
        if ($isPlainText) {
            parent::__construct((string)$value);
        } else {
            parent::__construct(base64_decode($value));
        }
    }

    public function __toString()
    {
        return base64_encode($this->value);
    }
}
