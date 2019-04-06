<?php


namespace Battis\Calendar;


use Battis\Calendar\Exceptions\PropertyException;
use Battis\Calendar\Exceptions\ValueException;
use Battis\Calendar\Standards\RFC5545;
use Battis\Calendar\Values\Text;
use Battis\Calendar\Values\ValueList;

abstract class Property
{
    /** @var Parameter[] */
    private $parameters = [];

    /** @var Value */
    private $value = null;

    /**
     * Property constructor.
     * @param Parameter[] $parameters
     * @param Value|Value[] $value
     * @throws PropertyException
     */
    public function __construct(array $parameters = [], $value = null)
    {
        $this->addAllParameters($parameters);
        $this->setValue($value);
    }

    /**
     * @param $value
     * @param bool $strict
     * @return Value
     * @throws ValueException
     */
    protected function autoboxPrimitives($value, bool $strict): Value
    {
        if (!($value instanceof Value)) {
            if (is_array($valueType = RFC5545::PROPERTY_VALUES[$this->getName()])) {
                foreach ($valueType as $type) {
                    if (preg_match('/^' . RFC5545::PROPERTY_VALUE_DATA_TYPES[$type] . '$/', $value) === 1) {
                        return new $type($value, $strict);
                    }
                }
                return new Text($value, $strict);
            }
            return new $valueType($value, $strict);
        }
        return $value;
    }

    /**
     * @param $value
     * @throws PropertyException
     */
    protected function strictValidation(Value $value): void
    {
        $validValues = RFC5545::PROPERTY_VALUES[$this->getName()];
        if (!(get_class($value) !== $validValues || is_array($validValues) && in_array(get_class($value), $validValues))) {
            throw new PropertyException(basename(get_class($value)) . ' is not a valid value type for ' . basename(get_class($this)));
        }
    }

    /**
     * @param mixed $value
     * @param bool $strict
     * @return Value
     * @throws PropertyException
     */
    public function setValue($value, bool $strict = false): ?Value
    {
        $previousValue = $this->value;
        $value = $this->autoboxPrimitives($value, $strict);
        if ($strict) {
            $this->strictValidation($value);
        }
        $this->value = $value;
        return $previousValue;
    }

    /**
     * @param Value $value
     * @param bool $strict
     * @return Value|null
     * @throws PropertyException
     * @throws ValueException
     */
    public function addValue(Value $value, bool $strict = false): ?Value
    {
        if ($this->value === null) {
            return $this->setValue($value, $strict);
        } elseif ($this->value instanceof ValueList) {
            return $this->value->addValue($value, $strict);
        } else {
            return $this->setValue(new ValueList([$this->value, $value]), $strict);
        }
    }

    /**
     * @return Value|Value[]|null
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getName(): string
    {
        if ($name = array_search(get_class($this), RFC5545::PROPERTIES)) {
            return $name;
        } else {
            return 'X-' . strtoupper(basename(get_class($this)));
        }
    }

    /**
     * @param string|Parameter $type (Optional, default `null`)
     * @return Parameter[]
     */
    public function getAllParameters($type = null): array
    {
        if ($type === null) {
            return $this->parameters;
        } else {
            return array_filter($this->parameters, function ($parameter) use ($type) {
                return $parameter instanceof $type;
            });
        }
    }

    public function addParameter(Parameter $parameter): void
    {
        array_push($this->parameters, $parameter);
    }

    /**
     * @param Parameter[] $parameters
     */
    public function addAllParameters(array $parameters): void
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchParameterInstance(Parameter $a, Parameter $b): bool
    {
        return $a === $b;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchParameterType(string $type, Parameter $p): bool
    {
        return $p instanceof $type;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */
    private static function matchParameterName(string $name, Parameter $p): bool
    {
        return $name == $p->getName();
    }

    /**
     * @param string|Parameter $parameter
     * @return array
     */
    private function determineParameterMatchCallback($parameter): array
    {
        $match = 'matchParameterName';
        if ($parameter instanceof Parameter) {
            if (is_string($parameter)) {
                $match = 'matchParameterType';
            } else {
                $match = 'matchParameterInstance';
            }
        }
        return [
            get_class($this),
            $match
        ];
    }

    public function getParameter($parameter): ?Parameter
    {
        $callback = $this->determineParameterMatchCallback($parameter);
        foreach ($this->parameters as $p) {
            if (call_user_func($callback, $parameter, $p)) {
                return $p;
            }
        }
        return null;
    }

    /**
     * @param string|Parameter $parameter
     * @param Parameter $replacement
     * @return Parameter|null
     */
    public function setParameter($parameter, Parameter $replacement): ?Parameter
    {
        $callback = $this->determineParameterMatchCallback($parameter);
        foreach ($this->parameters as $i => $p) {
            if (call_user_func($callback, $parameter, $p)) {
                $this->parameters[$i] = $replacement;
                return $p;
            }
        }
        $this->addParameter($replacement);
        return null;
    }

    /**
     * @param string|Parameter $parameter
     * @return Parameter|null
     */
    public function removeParameter($parameter): ?Parameter
    {
        $callback = $this->determineParameterMatchCallback($parameter);
        foreach ($this->parameters as $i => $p) {
            if (call_user_func($callback, $parameter, $p)) {
                unset($this->parameters[$i]);
                return $p;
            }
        }
        return null;
    }
}
