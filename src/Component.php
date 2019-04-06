<?php


namespace Battis\Calendar;


use Battis\Calendar\Properties\Component\Relationship\UniqueIdentifier;
use Battis\Calendar\Standards\RFC5545;


abstract class Component
{
    /** @var Property[] */
    private $properties = [];

    /** @var Component[] */
    private $components = [];

    /**
     * Component constructor.
     * @param Property[] $properties
     * @param Component[] $subcomponents
     */
    public function __construct(array $properties = [], array $subcomponents = [])
    {
        $this->addAllProperties($properties);
        $this->addAllComponents($subcomponents);
    }

    public function getType(): string
    {
        if ($type = array_search(get_class($this), RFC5545::COMPONENTS)) {
            return $type;
        } else {
            return strtoupper(basename(get_class($this)));
        }
    }

    /**
     * @param string|Property $type (Optional, default `null`)
     * @return Property[]
     */
    public function getAllProperties($type = null): array
    {
        if ($type === null) {
            return $this->properties;
        } else {
            return array_filter($this->properties, function ($property) use ($type) {
                return $property instanceof $type;
            });
        }
    }

    /**
     * @param string|Property $type
     * @return Property|null
     */
    public function getProperty($type): ?Property
    {
        foreach ($this->properties as $property) {
            if ($property instanceof $type) {
                return $property;
            }
        }
        return null;
    }

    public function addProperty(Property $property): void
    {
        array_push($this->properties, $property);
    }

    public function addAllProperties(array $properties): void
    {
        $this->properties = array_merge($this->properties, $properties);
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchPropertyInstance(Property $a, Property $b): bool
    {
        return $a === $b;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchPropertyType(string $type, Property $p): bool
    {
        return $p instanceof $type;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchPropertyName(string $name, Property $p): bool
    {
        return $name == $p->getName();
    }

    private function determinePropertyMatchCallback($property): array
    {
        $match = 'matchPropertyName';
        if ($property instanceof Property) {
            if (is_string($property)) {
                $match = 'matchPropertyType';
            } else {
                $match = 'matchPropertyInstance';
            }
        }
        return [
            get_class($this),
            $match
        ];
    }

    public function removeProperty($property): ?Property
    {
        $callback = $this->determinePropertyMatchCallback($property);
        foreach ($this->properties as $i => $p) {
            if (call_user_func($callback, $property, $p)) {
                unset($this->properties[$i]);
                return $p;
            }
        }
        return null;
    }

    public function setProperty($property, Property $replacement): ?Property
    {
        $callback = $this->determinePropertyMatchCallback($property);
        foreach ($this->properties as $i => $p) {
            if (call_user_func($callback, $property, $p)) {
                $this->properties[$i] = $replacement;
                return $p;
            }
        }
        $this->addProperty($replacement);
        return null;
    }

    /**
     * @param string|Component $type (Optional, default `null`)
     * @return Component[]
     */
    public function getAllComponents($type = null): array
    {
        if ($type === null) {
            return $this->components;
        } else {
            return array_filter($this->components, function ($component) use ($type) {
                return $component instanceof $type;
            });
        }
    }

    public function addComponent(Component $component): void
    {
        array_push($this->components, $component);
    }

    public function addAllComponents(array $components): void
    {
        $this->components = array_merge($this->components, $components);
    }

    /**
     * @param string|Component $type
     * @return Component|null
     */
    public function getComponent($type): ?Component
    {
        foreach ($this->components as $component) {
            if ($component instanceof $type) {
                return $component;
            }
        }
        return null;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchComponentInstance(Component $a, Component $b): bool
    {
        return $a === $b;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchUniqueIdentifierProperty(UniqueIdentifier $uid, Component $c): bool
    {
        /** @noinspection PhpNonStrictObjectEqualityInspection */
        return $uid == $c->getProperty(UniqueIdentifier::class);
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchUniqueIdentifierValue(string $uid, Component $c): bool
    {
        return $uid == (string)$c->getProperty(UniqueIdentifier::class)->getValue();
    }

    /**
     * @param string|UniqueIdentifier|Component $component
     * @return array
     */
    private function determineComponentMatchCallback($component): array
    {
        $match = 'matchUniqueIdentifierValue';
        if ($component instanceof UniqueIdentifier) {
            $match = 'matchUniqueIdentifierProperty';
        } elseif ($component instanceof Component) {
            $match = 'matchComponentInstance';
        }
        return [
            get_class($this),
            $match
        ];
    }

    /**
     * @param UniqueIdentifier|string|Component $component
     * @param Component $replacement
     * @return Component|null
     */
    public function setComponent($component, Component $replacement): ?Component
    {
        $callback = $this->determineComponentMatchCallback($component);
        foreach ($this->components as $i => $c) {
            if (call_user_func($callback, $component, $c)) {
                $previousValue = $c;
                $this->components[$i] = $replacement;
                return $previousValue;
            }
        }
        $this->addComponent($replacement);
        return null;
    }

    /**
     * @param UniqueIdentifier|string|Component $component
     * @return Component|null
     */
    public function removeComponent($component): ?Component
    {
        $callback = $this->determineComponentMatchCallback($component);
        foreach ($this->components as $i => $c) {
            if (call_user_func($callback, $component, $c)) {
                unset($this->components[$i]);
                return $c;
            }
        }
        return null;
    }
}
