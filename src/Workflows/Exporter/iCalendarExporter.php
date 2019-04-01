<?php


namespace Battis\Calendar\Workflows\Exporter;


use Battis\Calendar\Component;
use Battis\Calendar\Parameter;
use Battis\Calendar\Property;
use Battis\Calendar\Standards\RFC5545;
use Battis\Calendar\Value;
use Battis\Calendar\Workflows\Exporter;

class iCalendarExporter implements RFC5545, Exporter
{
    public static function export(Component $component): string
    {
        return self::fold(self::exportComponent($component));
    }

    private static function fold(string $text): string
    {
        $lines = explode(self::CRLF, $text);
        $folded = [];
        foreach ($lines as $line) {
            while (mb_strlen($line) > self::CONTENTLINE_WIDTH) {
                array_push($folded, mb_strcut($line, 0, self::CONTENTLINE_WIDTH));
                $line = ' ' . mb_strcut($line, self::CONTENTLINE_WIDTH);
            }
            array_push($folded, $line);
        }
        return implode(self::CRLF, $folded);
    }

    private static function exportComponent(Component $component): string
    {
        $text = 'BEGIN:' . $component->getType() . RFC5545::CRLF;
        foreach ($component->getPropertiesIterator() as $property) {
            $text .= self::exportProperty($property);
        }
        foreach ($component->getComponentsIterator() as $subcomponent) {
            $text .= self::exportComponent($subcomponent);
        }
        $text .= 'END:' . $component->getType() . RFC5545::CRLF;
        return $text;
    }

    private static function exportProperty(Property $property): string
    {
        $text = $property->getName();
        foreach ($property->getParametersIterator() as $parameter) {
            $text .= ';' . self::exportParameter($parameter);
        }
        $text .= ':' . self::exportValue($property->getValue()) . RFC5545::CRLF;
        return $text;
    }

    private static function exportParameter(Parameter $parameter): string
    {
        $text = $parameter->getName() . '=';
        if (is_array($parameter->getValue())) {
            $values = [];
            foreach ($parameter->getValueIterator() as $value) {
                array_push($values, self::exportValue($value));
            }
            $text .= implode(',', $values);
        } else {
            $text .= self::exportValue($parameter->getValue());
        }
        return $text;
    }

    private static function exportValue(Value $value): string
    {
        return (string)$value;
    }
}
