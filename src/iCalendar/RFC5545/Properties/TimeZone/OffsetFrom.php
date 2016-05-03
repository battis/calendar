<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\UTCOffset;

/**
Time Zone Offset From Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.3 RFC 5545 &sect;3.8.3}
```RFC
The following properties specify time zone information in calendar
components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.3.3 RFC 5545 &sect;3.8.3.3}
```RFC
Purpose:  This property specifies the offset that is in use prior to
	 this time zone observance.
```
```RFC
Description:  This property specifies the offset that is in use prior
	 to this time observance.  It is used to calculate the absolute
	 time at which the transition to a given observance takes place.
	 This property MUST only be specified in a "VTIMEZONE" calendar
	 component.  A "VTIMEZONE" calendar component MUST include this
	 property.  The property value is a signed numeric indicating the
	 number of hours and possibly minutes from UTC.  Positive numbers
	 represent time zones east of the prime meridian, or ahead of UTC.
	 Negative numbers represent time zones west of the prime meridian,
	 or behind UTC.
```
*/
class OffsetFrom extends Property {

	protected $name = 'TZOFFSETFROM';

	protected static $validValueTypes = [
		UTCOffset::class
	];
}
