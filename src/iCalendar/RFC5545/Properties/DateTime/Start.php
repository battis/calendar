<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Properties\DefaultDateTimeProperty;

/**
Date-Time Start Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.4 RFC 5545 &sect;3.8.2.4}
```RFC
Purpose:  This property specifies when the calendar component begins.
```
```RFC
Description:  Within the "VEVENT" calendar component, this property
	 defines the start date and time for the event.

	 Within the "VFREEBUSY" calendar component, this property defines
	 the start date and time for the free or busy time information.
	 The time MUST be specified in UTC time.

	 Within the "STANDARD" and "DAYLIGHT" sub-components, this property
	 defines the effective start date and time for a time zone
	 specification.  This property is REQUIRED within each "STANDARD"
	 and "DAYLIGHT" sub-components included in "VTIMEZONE" calendar
	 components and MUST be specified as a date with local time without
	 the "TZID" property parameter.
```
*/
class Start extends DefaultDateTimeProperty {

	protected $name = 'DTSTART';
}
