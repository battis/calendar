<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Miscellaneous;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;
use Battis\Calendar\iCalendar\RFC5545\Value;
use Battis\Calendar\iCalendar\Exceptions\PropertyException;

/**
IANA Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.8 RFC 5545 &sect;3.8.8}
```RFC
The following properties specify information about a number of
miscellaneous features of calendar components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.8.1 RFC 5545 &sect;3.8.8.1}
```RFC
Description:  This specification allows other properties registered
	 with IANA to be specified in any calendar components.  Compliant
	 applications are expected to be able to parse these other IANA-
	 registered properties but can ignore them.
```
*/
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
