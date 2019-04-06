<?php


namespace Battis\Calendar\Components;


use Battis\Calendar\Component;
use Battis\Calendar\Parameter;

class Undefined extends Component
{
    /** @var string */
    private $type;

    /**
     * Undefined constructor.
     * @param string $type
     * @param Parameter[] $parameters
     * @param Component[] $subcomponents
     */
    public function __construct(string $type, array $parameters = [], array $subcomponents = [])
    {
        parent::__construct($parameters, $subcomponents);
        $this->type = $type;
    }

    public function getType(): string
    {
        return strtoupper($this->type);
    }
}
