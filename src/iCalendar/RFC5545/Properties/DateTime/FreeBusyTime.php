<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\Period;

/**
Free/Busy Time Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2 RFC 5545 &sect;3.8.2}
```RFC
The following properties specify date and time related information in
calendar components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.6 RFC 5545 &sect;3.8.2.6}
```RFC
Purpose:  This property defines one or more free or busy time
	 intervals.
```
```RFC
Description:  These time periods can be specified as either a start
	 and end DATE-TIME or a start DATE-TIME and DURATION.  The date and
	 time MUST be a UTC time format.

	 "FREEBUSY" properties within the "VFREEBUSY" calendar component
	 SHOULD be sorted in ascending order, based on start time and then
	 end time, with the earliest periods first.

	 The "FREEBUSY" property can specify more than one value, separated
	 by the COMMA character.  In such cases, the "FREEBUSY" property
	 values MUST all be of the same "FBTYPE" property parameter type
	 (e.g., all values of a particular "FBTYPE" listed together in a
	 single property).
```
*/
class Duration extends Property {

	protected $name = 'FREEBUSY';

	protected static $validValueTypes = [
		Period::class
	];
}
