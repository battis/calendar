<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\IntegerProperty;

/**
Priority Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1 RFC 5545 &sect;3.8.1}
```RFC
The following properties specify descriptive information about
calendar components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.9 RFC 5545 &sect;3.8.1.9}
```RFC
Purpose:  This property defines the relative priority for a calendar
	 component.
```
```RFC
Description:  This priority is specified as an integer in the range 0
	 to 9.  A value of 0 specifies an undefined priority.  A value of 1
	 is the highest priority.  A value of 2 is the second highest
	 priority.  Subsequent numbers specify a decreasing ordinal
	 priority.  A value of 9 is the lowest priority.

	 A CUA with a three-level priority scheme of "HIGH", "MEDIUM", and
	 "LOW" is mapped into this property such that a property value in
	 the range of 1 to 4 specifies "HIGH" priority.  A value of 5 is
	 the normal or "MEDIUM" priority.  A value in the range of 6 to 9
	 is "LOW" priority.

	 A CUA with a priority schema of "A1", "A2", "A3", "B1", "B2", ...,
	 "C3" is mapped into this property such that a property value of 1
	 specifies "A1", a property value of 2 specifies "A2", a property
	 value of 3 specifies "A3", and so forth up to a property value of
	 9 specifies "C3".

	 Other integer values are reserved for future use.

	 Within a "VEVENT" calendar component, this property specifies a
	 priority for the event.  This property may be useful when more
	 than one event is scheduled for a given time period.

	 Within a "VTODO" calendar component, this property specified a
	 priority for the to-do.  This property is useful in prioritizing
	 multiple action items for a given time period.
```
*/
class Priority extends IntegerProperty {

	protected $name = 'PRIORITY';
}
