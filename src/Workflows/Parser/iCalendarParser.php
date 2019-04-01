<?php


namespace Battis\Calendar\Workflows\Parser;


use Battis\Calendar\Component;
use Battis\Calendar\Components\Undefined;
use Battis\Calendar\Exceptions\ValueException;
use Battis\Calendar\Parameter;
use Battis\Calendar\Parameters\IANAParameter;
use Battis\Calendar\Parameters\NonStandardParameter;
use Battis\Calendar\Properties\Component\Miscellaneous\IANAProperty;
use Battis\Calendar\Properties\Component\Miscellaneous\NonStandardProperty;
use Battis\Calendar\Property;
use Battis\Calendar\Standards\RFC5545;
use Battis\Calendar\Value;
use Battis\Calendar\Values\Text;
use Battis\Calendar\Workflows\Parser;

class iCalendarParser implements Parser
{
    private function __construct()
    {
    }

    /**
     * @param string $text
     * @return Component
     * @throws ValueException
     */
    public static function parse(string $text): Component
    {
        $unparsed = explode(RFC5545::CRLF, self::unfold($text));
        while (($line = array_shift($unparsed)) !== null) {
            foreach (RFC5545::COMPONENTS as $name => $type) {
                if (strtoupper($line) === "BEGIN:$name") {
                    return self::parseComponent($unparsed, $name);
                }
            }
        }
        return null;
    }

    /**
     * @param string $text
     * @return string[]
     */
    private static function unfold(string $text): string
    {
        return preg_replace('/' . RFC5545::CRLF . RFC5545::WSP . '/', '', $text);
    }

    /**
     * @param string[] $unparsed
     * @param string|null $name
     * @return Component
     * @throws ValueException
     */
    private static function parseComponent(array &$unparsed, string $name = null)
    {
        $properties = [];
        $subcomponents = [];
        $end = false;
        while (!($end || empty($unparsed))) {
            $line = array_shift($unparsed);
            if (preg_match("/^END:$name$/i", $line)) {
                $end = true;
            } elseif (preg_match('/^BEGIN:([A-Z0-9\\-]+)$/', $line, $match)) {
                array_push($subcomponents, self::parseComponent($unparsed, $match[1]));
            } elseif (!empty($line)) {
                array_push($properties, self::parseProperty($line));
            }
        }
        return self::instantiateComponent($name, $properties, $subcomponents);
    }

    private static function instantiateComponent(string $name, array $properties = [], array $subcomponents = []): Component
    {
        if (isset(RFC5545::COMPONENTS[$name])) {
            /** @var Component $componentType */
            $componentType = RFC5545::COMPONENTS[$name];
            return new $componentType($properties, $subcomponents);
        } else {
            return new Undefined($name, $properties, $subcomponents);
        }
    }

    /**
     * @param string $unparsed
     * @return Property|null
     * @throws ValueException
     */
    private static function parseProperty(string $unparsed)
    {
        preg_match('/^([A-Z0-9\\-]+)([;:].+)$/i', $unparsed, $match);
        if (empty($match)) {
            var_dump($unparsed);
            return null;
        }
        $name = $match[1];
        $parameters = [];
        $unparsed = $match[2];
        $cursor = 0;
        $quoted = false;
        while (!empty($unparsed)) {
            switch ($unparsed[$cursor]) {
                case ';':
                    if (!$quoted) {
                        if ($cursor === 0) {
                            $unparsed = substr($unparsed, 1);
                            continue;
                        }
                        $parameter = self::parseParameter(substr($unparsed, 0, $cursor));
                        $parameters[$parameter->getName()] = $parameter;
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
                case ':':
                    if (!$quoted) {
                        if ($cursor > 0) {
                            array_push($parameters, self::parseParameter(substr($unparsed, 0, $cursor)));
                        }
                        $value = self::parseValue(self::getValueType($name, $parameters), substr($unparsed, $cursor + 1));
                        $unparsed = null;
                    }
                    break;
                case '\\':
                    $cursor++; // skip escaped character;
                    break;
                case '"':
                    $quoted = !$quoted;
                    break;
            }
            $cursor++;
        }
        return self::instantiateProperty($name, $parameters, $value);
    }

    /**
     * @param string $label
     * @param Parameter[] $parameters
     * @return string|string[]
     */
    private static function getValueType(string $label, array $parameters)
    {
        if (isset($parameters[RFC5545::ValueDataTypes])) {
            return $parameters[RFC5545::ValueDataTypes];
        }
        if (isset(RFC5545::PROPERTY_VALUES[$label])) {
            return RFC5545::PROPERTY_VALUES[$label];
        }
        return Text::class;
    }

    /**
     * @param string $name
     * @param Parameter[] $parameters
     * @param Value|Value[] $value
     * @return Property
     */
    private static function instantiateProperty(string $name, array $parameters = [], $value = null): Property
    {
        if (empty(RFC5545::PROPERTIES[strtoupper($name)])) {
            if (strpos($name, 'X-') === 0) {
                return new NonStandardProperty($name, $parameters, $value);
            } else {
                return new IANAProperty($name, $parameters, $value);
            }
        } else {
            /** @var Property $propertyType */
            $propertyType = RFC5545::PROPERTIES[strtoupper($name)];
            return new $propertyType($parameters, $value);
        }
    }

    /**
     * @param string $unparsed
     * @return Parameter
     * @throws ValueException
     */
    private static function parseParameter(string $unparsed)
    {
        preg_match('/^([A-Z0-9\\-]+)=(.*)$/i', $unparsed, $match);
        $name = $match[1];
        $value = null;
        $unparsed = $match[2];
        $cursor = 0;
        $quoted = false;
        while ($cursor < strlen($unparsed)) {
            switch ($unparsed[$cursor]) {
                case '"':
                    $quoted = !$quoted;
                    break;
                case '\\':
                    $cursor++; // skip escaped character
                    break;
                case ',':
                    if (!$quoted) {
                        if ($value === null) {
                            $value = [];
                        }
                        array_push($value, self::instantiateValue(RFC5545::PROPERTY_PARAMETER_VALUES[$name], substr($unparsed, 0, $cursor)));
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
            }
            $cursor++;
        }
        return self::instantiateParameter($match[1], $match[2]);
    }

    private static function instantiateParameter(string $name, $value): Parameter
    {
        if (empty(RFC5545::PROPERTY_PARAMETERS[strtoupper($name)])) {
            if (strpos($name, 'X-') === 0) {
                return new NonStandardParameter($name, $value);
            } else {
                return new IANAParameter($name, $value);
            }
        } else {
            /** @var Parameter $parameterType */
            $parameterType = RFC5545::PROPERTY_PARAMETERS[strtoupper($name)];
            return new $parameterType($value);
        }
    }

    /**
     * @param string|string[] $expectedType
     * @param string $unparsed
     * @return Value|Value[]
     * @throws ValueException
     */
    private static function parseValue($expectedType, string $unparsed)
    {
        $value = null;
        $cursor = 0;
        $quoted = false;
        $field = null;
        $structured = false;
        while ($cursor < strlen($unparsed)) {
            switch ($unparsed[$cursor]) {
                case '"':
                    $quoted = !$quoted;
                    break;
                case '\\':
                    $cursor++; // skip escaped character
                    break;
                case ',':
                    if (!$quoted) {
                        if ($value === null) {
                            $value = [];
                        }
                        array_push($value, self::parseValue($expectedType, substr($unparsed, 0, $cursor)));
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
                case '=':
                    if (!$quoted && $expectedType !== Text::class) {
                        $structured = true;
                        $field = substr($unparsed, 0, $cursor);
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
                case ';':
                    if (!$quoted && $expectedType !== Text::class) {
                        $value[$field] = substr($unparsed, 0, $cursor);
                        unset($field);
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
            }
            $cursor++;
        }
        if (!empty($unparsed)) {
            if (is_array($value)) {
                if ($structured) {
                    $value[$field] = $unparsed;
                    return self::instantiateValue($expectedType, $value);
                } else {
                    array_push($value, self::parseValue($expectedType, $unparsed));
                }
            } else {
                return self::instantiateValue($expectedType, $unparsed);
            }
        }
        return $value;
    }

    /**
     * @param $expectedType
     * @param $value
     * @return Text
     * @throws ValueException
     */
    private static function instantiateValue($expectedType, $value)
    {
        if (is_array($expectedType)) {
            foreach ($expectedType as $type) {
                if (preg_match('/^' . RFC5545::PROPERTY_VALUE_DATA_TYPES[$type] . '$/', $value)) {
                    return new $type($value);
                }
            }
            return new Text($value);
        }
        return new $expectedType($value);
    }
}
