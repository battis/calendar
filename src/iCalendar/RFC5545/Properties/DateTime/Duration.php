<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\Duration as DurationValue;

/**
Duration Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.5 RFC 5545 &sect;3.8.2.5}
```RFC
Purpose:  This property specifies a positive duration of time.
```
```RFC
Description:  In a "VEVENT" calendar component the property may be
	 used to specify a duration of the event, instead of an explicit
	 end DATE-TIME.  In a "VTODO" calendar component the property may
	 be used to specify a duration for the to-do, instead of an
	 explicit due DATE-TIME.  In a "VALARM" calendar component the
	 property may be used to specify the delay period prior to
	 repeating an alarm.  When the "DURATION" property relates to a
	 "DTSTART" property that is specified as a DATE value, then the
	 "DURATION" property MUST be specified as a "dur-day" or "dur-week"
	 value.
```
*/
class Duration extends Property {

	protected $name = 'DURATION';

	protected static $validValueTypes = [
		DurationValue::class
	];
}
