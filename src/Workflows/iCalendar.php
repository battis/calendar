<?php


namespace Battis\Calendar\Workflows;


use Battis\Calendar\Calendar;
use Battis\Calendar\Component;
use Battis\Calendar\Components\Undefined;
use Battis\Calendar\Exceptions\PropertyException;
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
use Battis\Calendar\Values\ValueList;

class iCalendar implements Parser, Exporter
{
    /************************************************************************
     * Parser
     ************************************************************************/

    const
        REGEX_START = '/^',
        REGEX_END = '$/i';

    private function __construct()
    {
    }

    /**
     * @param string $path
     * @param Calendar|string $type
     * @param mixed ...$constructorParameters
     * @return Component
     * @throws ValueException
     * @throws PropertyException
     */
    public static function parseFile(string $path, $type = null, ...$constructorParameters): Component
    {
        return self::parse(file_get_contents($path), $type, ...$constructorParameters);
    }

    /**
     * @param string $text
     * @param Calendar|string $type (Optional, default `null`)
     * @param mixed $constructorParameters
     * @return Component|null
     * @throws ValueException
     * @throws PropertyException
     */
    public static function parse(string $text, $type = null, ...$constructorParameters): ?Component
    {
        $unparsed = explode(RFC5545::CRLF, self::unfold($text));
        while (($line = array_shift($unparsed)) !== null) {
            if (preg_match(self::REGEX_START . RFC5545::COMPONENT_BEGIN . '(' . RFC5545::IANA_TOKEN . ')' . self::REGEX_END, $line, $match)) {
                if ($type === null && isset(RFC5545::COMPONENTS[$match[1]])) {
                    $type = RFC5545::COMPONENTS[$match[1]];
                }
                return self::parseComponent($unparsed, $match[1], $type, ...$constructorParameters);
            }
        }
        return null;
    }

    /**
     * @param string $text
     * @return string
     */
    private static function unfold(string $text): string
    {
        return preg_replace('/' . RFC5545::CRLF . RFC5545::WSP . '/', '', $text);
    }

    /**
     * @param string[] $unparsed
     * @param string|null $name
     * @param Component|string $type (Optional, default `null`)
     * @param mixed $constructorParameters
     * @return Component|null
     * @throws ValueException
     * @throws PropertyException
     */
    private static function parseComponent(array &$unparsed, ?string $name = null, $type = null, ...$constructorParameters): ?Component
    {
        $properties = [];
        $subcomponents = [];
        $end = false;
        while (!($end || empty($unparsed))) {
            $line = array_shift($unparsed);
            if (preg_match(self::REGEX_START . RFC5545::COMPONENT_END . $name . self::REGEX_END, $line)) {
                $end = true;
            } elseif (preg_match(self::REGEX_START . RFC5545::COMPONENT_BEGIN . '(' . RFC5545::IANA_TOKEN . ')' . self::REGEX_END, $line, $match)) {
                array_push($subcomponents, self::parseComponent($unparsed, $match[1]));
            } elseif (!empty($line)) {
                array_push($properties, self::parseProperty($line));
            }
        }
        return self::instantiateComponent($name, $properties, $subcomponents, $type, ...$constructorParameters);
    }

    /**
     * @param string $name
     * @param array $properties
     * @param array $subcomponents
     * @param Component|string $type (Optional, default `null`)
     * @return Component
     */
    private static function instantiateComponent(string $name, array $properties = [], array $subcomponents = [], $type = null, ...$constructorParameters): Component
    {
        if ($type !== null) {
            if (!is_string($type)) {
                $type = get_class($type);
            }
            return new $type($properties, $subcomponents, ...$constructorParameters);
        } else if (isset(RFC5545::COMPONENTS[$name])) {
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
     * @throws PropertyException
     */
    private static function parseProperty(string $unparsed): ?Property
    {
        preg_match(self::REGEX_START . '(' . RFC5545::NAME . ')([' . RFC5545::PARAMETER_SEPARATOR . RFC5545::VALUE_SEPARATOR . '].+)' . self::REGEX_END, $unparsed, $match);
        $name = $match[1];
        $parameters = [];
        $value = null;
        $unparsed = $match[2];
        $cursor = 0;
        $quoted = false;
        while (!empty($unparsed)) {
            switch ($unparsed[$cursor]) {
                case RFC5545::PARAMETER_SEPARATOR:
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
                case RFC5545::VALUE_SEPARATOR:
                    if (!$quoted) {
                        if ($cursor > 0) {
                            array_push($parameters, self::parseParameter(substr($unparsed, 0, $cursor)));
                        }
                        $value = self::parseValue(self::getValueType($name, $parameters), substr($unparsed, $cursor + 1));
                        $unparsed = null;
                    }
                    break;
                case RFC5545::ESCAPE_CHAR:
                    $cursor++; // skip escaped character;
                    break;
                case RFC5545::DQUOTE:
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
        if (isset($parameters[RFC5545::VALUE_DATA_TYPES])) {
            return $parameters[RFC5545::VALUE_DATA_TYPES];
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
     * @throws PropertyException
     */
    private static function instantiateProperty(string $name, array $parameters = [], $value = null): Property
    {
        if (empty($value)) {
            throw new PropertyException('Properties must have a value');
        }
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
     * @return Parameter|null
     * @throws ValueException
     */
    private static function parseParameter(string $unparsed): ?Parameter
    {
        preg_match(self::REGEX_START . '(' . RFC5545::PARAM_NAME . ')' . RFC5545::PARAMETER_KEYVALUE_SEPARATOR . '(.*)' . self::REGEX_END, $unparsed, $match);
        $name = $match[1];
        $value = null;
        $unparsed = $match[2];
        $cursor = 0;
        $quoted = false;
        while ($cursor < strlen($unparsed)) {
            switch ($unparsed[$cursor]) {
                case RFC5545::DQUOTE:
                    $quoted = !$quoted;
                    break;
                case RFC5545::ESCAPE_CHAR:
                    $cursor++; // skip escaped character
                    break;
                case RFC5545::LIST_SEPARATOR:
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
     * @return Value|null
     * @throws ValueException
     */
    private static function parseValue($expectedType, string $unparsed): ?Value
    {
        $value = null;
        $cursor = 0;
        $quoted = false;
        $field = null;
        $structured = false;
        while ($cursor < strlen($unparsed)) {
            switch ($unparsed[$cursor]) {
                case RFC5545::DQUOTE:
                    $quoted = !$quoted;
                    break;
                case RFC5545::ESCAPE_CHAR:
                    $cursor++; // skip escaped character
                    break;
                case RFC5545::LIST_SEPARATOR:
                    if (!$quoted) {
                        if ($value === null) {
                            $value = [];
                        }
                        array_push($value, self::parseValue($expectedType, substr($unparsed, 0, $cursor)));
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
                case RFC5545::PARAMETER_KEYVALUE_SEPARATOR:
                    if (!$quoted && $expectedType !== Text::class) {
                        $structured = true;
                        $field = substr($unparsed, 0, $cursor);
                        $unparsed = substr($unparsed, $cursor + 1);
                        $cursor = -1;
                    }
                    break;
                case RFC5545::FIELD_SEPARATOR:
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
                    return self::instantiateValue($expectedType, $value, $structured);
                } else {
                    array_push($value, self::parseValue($expectedType, $unparsed));
                    return self::instantiateValue($expectedType, $value);
                }
            } else {
                return self::instantiateValue($expectedType, $unparsed);
            }
        }
        echo $value . PHP_EOL;
        return self::instantiateValue($expectedType, $value);
    }

    /**
     * @param $expectedType
     * @param array|string $value
     * @param bool $structured (Optional, default `false`)
     * @return Value
     * @throws ValueException
     */
    private static function instantiateValue($expectedType, $value, bool $structured = false)
    {
        if (is_array($value) && !$structured) {
            return new ValueList($value);
        }

        // only one structured type (RecurrenceRule), and it's not included a list of possible types
        if (is_array($expectedType)) {
            foreach ($expectedType as $type) {
                if (preg_match(self::REGEX_START . RFC5545::PROPERTY_VALUE_DATA_TYPES[$type] . self::REGEX_END, implode(RFC5545::FIELD_SEPARATOR, $value))) {
                    return new $type($value);
                }
            }
            return new Text($value);
        }
        return new $expectedType($value);
    }

    /************************************************************************
     * Exporter
     ************************************************************************/

    public static function exportToFile(Component $component, string $path)
    {
        file_put_contents($path, self::export($component));
    }

    public static function export(Component $component): string
    {
        return self::fold(self::exportComponent($component));
    }

    private static function fold(string $text): string
    {
        $lines = explode(RFC5545::CRLF, $text);
        $folded = [];
        foreach ($lines as $line) {
            while (mb_strlen($line) > RFC5545::CONTENTLINE_WIDTH) {
                array_push($folded, mb_strcut($line, 0, RFC5545::CONTENTLINE_WIDTH));
                $line = ' ' . mb_strcut($line, RFC5545::CONTENTLINE_WIDTH);
            }
            array_push($folded, $line);
        }
        return implode(RFC5545::CRLF, $folded);
    }

    private static function exportComponent(Component $component): string
    {
        $text = 'BEGIN:' . $component->getType() . RFC5545::CRLF;
        foreach ($component->getAllProperties() as $property) {
            $text .= self::exportProperty($property);
        }
        foreach ($component->getAllComponents() as $subcomponent) {
            $text .= self::exportComponent($subcomponent);
        }
        $text .= 'END:' . $component->getType() . RFC5545::CRLF;
        return $text;
    }

    private static function exportProperty(Property $property): string
    {
        $text = $property->getName();
        foreach ($property->getAllParameters() as $parameter) {
            $text .= RFC5545::PARAMETER_SEPARATOR . self::exportParameter($parameter);
        }
        $text .= RFC5545::VALUE_SEPARATOR . self::exportValue($property->getValue()) . RFC5545::CRLF;
        return $text;
    }

    private static function exportParameter(Parameter $parameter): string
    {
        $text = $parameter->getName() . RFC5545::PARAMETER_KEYVALUE_SEPARATOR;
        if (is_array($parameter->getValue())) {
            $values = [];
            foreach ($parameter->getValue() as $value) {
                array_push($values, self::exportValue($value));
            }
            $text .= implode(RFC5545::LIST_SEPARATOR, $values);
        } else {
            $text .= self::exportValue($parameter->getValue());
        }
        return $text;
    }

    private static function exportValue($value): string
    {
        return (string)$value;
    }

}
