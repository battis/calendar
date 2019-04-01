<?php


namespace Battis\Calendar;


use ArrayIterator;
use Battis\Calendar\Standards\RFC5545;

abstract class Component
{
    /** @var Parameter[] */
    private $properties = [];

    /** @var Component[] */
    private $components = [];

    /**
     * Component constructor.
     * @param array $properties
     * @param Component[] $subcomponents
     */
    public function __construct(array $properties = [], array $subcomponents = [])
    {
        $this->properties = $properties;
        $this->components = $subcomponents;
    }

    public function getType(): string
    {
        return array_search(get_class($this), RFC5545::COMPONENTS) ||
            strtoupper(basename(get_class($this)));
    }

    public function getPropertiesIterator(): ArrayIterator
    {
        return new ArrayIterator($this->properties);
    }

    public function setProperty(Property $property): ?Property
    {
        // FIXME can have multiple of same-name properties
        $previousValue = null;
        if (isset($this->properties[$property->getName()])) {
            $previousValue = $this->properties[$property->getName()];
        }
        $this->properties[$property->getName()] = $property;
        return $previousValue;
    }

    public function getComponentsIterator(): ArrayIterator
    {
        return new ArrayIterator($this->components);
    }

    public function addComponent(Component $component): void
    {
        array_push($this->components, $component);
    }
}
