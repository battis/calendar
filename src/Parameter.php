<?php


namespace Battis\Calendar;


use Battis\Calendar\Standards\RFC5545;

abstract class Parameter
{
    /** @var string */
    private $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }

    public function getName(): string
    {
        if ($name = array_search(get_class($this), RFC5545::PROPERTY_PARAMETERS)) {
            return $name;
        } else {
            return 'X-' . strtoupper(basename(get_class($this)));
        }
    }

    public function getValue()
    {
        return $this->value;
    }
}
