<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard;

use Battis\Calendar\iCalendar\RFC2445\Properties\TextProperty;
use Battis\Calendar\iCalendar\RFC2445\Value;
use Battis\Calendar\iCalendar\Exceptions\PropertyException;

class IANAProperty extends TextProperty {

	public function __construct(...$param) {
		if (count($param) >= 2 && is_string($param[0]) && is_a($param[1], Value::class)) {
			$this->name = $param[0];
			$this->setValue($param[1]);
			$parameters = array_slice($param, 2);
			if (!empty($parameters)) {
				$this->set(...$parameters);
			}
		} else {
			throw new PropertyException('IANA Property must be constructed from a name, value and, optionally, parameters');
		}
	}

}