<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC5545\Properties\DefaultDateTimeProperty;
use Battis\Calendar\iCalendar\RFC5545\Values\DateTime;
use Battis\Calendar\iCalendar\RFC5545\Values\Date;

/**
Recurrence ID Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4 RFC 5545 &sect;3.8.4}
```RFC
The following properties specify relationship information in calendar
components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4.4 RFC 5545 &sect;3.8.4.4}
```RFC
Purpose:  This property is used in conjunction with the "UID" and
	 "SEQUENCE" properties to identify a specific instance of a
	 recurring "VEVENT", "VTODO", or "VJOURNAL" calendar component.
	 The property value is the original value of the "DTSTART" property
	 of the recurrence instance.
```
```RFC
Description:  The full range of calendar components specified by a
	 recurrence set is referenced by referring to just the "UID"
	 property value corresponding to the calendar component.  The
	 "RECURRENCE-ID" property allows the reference to an individual
	 instance within the recurrence set.

	 If the value of the "DTSTART" property is a DATE type value, then
	 the value MUST be the calendar date for the recurrence instance.

	 The DATE-TIME value is set to the time when the original
	 recurrence instance would occur; meaning that if the intent is to
	 change a Friday meeting to Thursday, the DATE-TIME is still set to
	 the original Friday meeting.

	 The "RECURRENCE-ID" property is used in conjunction with the "UID"
	 and "SEQUENCE" properties to identify a particular instance of a
	 recurring event, to-do, or journal.  For a given pair of "UID" and
	 "SEQUENCE" property values, the "RECURRENCE-ID" value for a
	 recurrence instance is fixed.

	 The "RANGE" parameter is used to specify the effective range of
	 recurrence instances from the instance specified by the
	 "RECURRENCE-ID" property value.  The value for the range parameter
	 can only be "THISANDFUTURE" to indicate a range defined by the
	 given recurrence instance and all subsequent instances.
	 Subsequent instances are determined by their "RECURRENCE-ID" value
	 and not their current scheduled start time.  Subsequent instances
	 defined in separate components are not impacted by the given
	 recurrence instance.  When the given recurrence instance is
	 rescheduled, all subsequent instances are also rescheduled by the
	 same time difference.  For instance, if the given recurrence
	 instance is rescheduled to start 2 hours later, then all
	 subsequent instances are also rescheduled 2 hours later.

	 Similarly, if the duration of the given recurrence instance is
	 modified, then all subsequence instances are also modified to have
	 this same duration.

			Note: The "RANGE" parameter may not be appropriate to
			reschedule specific subsequent instances of complex recurring
			calendar component.  Assuming an unbounded recurring calendar
			component scheduled to occur on Mondays and Wednesdays, the
			"RANGE" parameter could not be used to reschedule only the
			future Monday instances to occur on Tuesday instead.  In such
			cases, the calendar application could simply truncate the
			unbounded recurring calendar component (i.e., with the "COUNT"
			or "UNTIL" rule parts), and create two new unbounded recurring
			calendar components for the future instances.
```
*/
class RecurrenceID extends DefaultDateTimeProperty {

	protected $name = 'RECURRENCE-ID';
}
