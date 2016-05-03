<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Properties\DefaultDateTimeProperty;

/**
Date-Time End Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.2 RFC 5545 &sect;3.8.2.2}
```RFC
Purpose:  This property specifies the date and time that a calendar
	 component ends.
```
```RFC
Description:  Within the "VEVENT" calendar component, this property
	 defines the date and time by which the event ends.  The value type
	 of this property MUST be the same as the "DTSTART" property, and
	 its value MUST be later in time than the value of the "DTSTART"
	 property.  Furthermore, this property MUST be specified as a date
	 with local time if and only if the "DTSTART" property is also
	 specified as a date with local time.

	 Within the "VFREEBUSY" calendar component, this property defines
	 the end date and time for the free or busy time information.  The
	 time MUST be specified in the UTC time format.  The value MUST be
	 later in time than the value of the "DTSTART" property.
```
*/
class End extends DefaultDateTimeProperty {

	protected $name = 'DTEND';
}
