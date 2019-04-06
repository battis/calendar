<?php


namespace Battis\Calendar\Values;


use Battis\Calendar\Exceptions\ValueException;
use Battis\Calendar\Standards\RFC5545;
use Battis\Calendar\Value;

class ValueList extends Value
{
    protected function validate($values): void
    {
        if (is_array($values)) {
            $type = null;
            foreach ($values as $value) {
                if ($type === null) {
                    $type = get_class($value);
                } elseif (!(get_class($value) instanceof $type)) {
                    throw new ValueException('All values in array must be same type');
                }
            }
        } else {
            throw new ValueException('Must be an array of values of same type');
        }
    }

    /**
     * @param Value $value
     * @param bool $strict (Optional, default `false`)
     * @return mixed
     * @throws ValueException
     */
    public function addValue(Value $value, bool $strict = false)
    {
        return $this->setValue(array_merge($this->getValue(), [$value]), $strict);
    }

    public function __toString()
    {
        return implode(RFC5545::LIST_SEPARATOR, $this->getValue());
    }
}
