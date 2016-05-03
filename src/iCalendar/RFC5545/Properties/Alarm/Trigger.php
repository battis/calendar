<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Alarm;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\Duration;
use Battis\Calendar\iCalendar\RFC5545\Values\DateTime;

/**
Trigger Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.6 RFC 5545 &sect;3.8.6}
```RFC
The following properties specify alarm information in calendar
components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.6.3 RFC 5545 &sect;3.8.6.3}
```RFC
Purpose:  This property specifies when an alarm will trigger.
```
```RFC
Description:  This property defines when an alarm will trigger.  The
	 default value type is DURATION, specifying a relative time for the
	 trigger of the alarm.  The default duration is relative to the
	 start of an event or to-do with which the alarm is associated.
	 The duration can be explicitly set to trigger from either the end
	 or the start of the associated event or to-do with the "RELATED"
	 parameter.  A value of START will set the alarm to trigger off the
	 start of the associated event or to-do.  A value of END will set
	 the alarm to trigger off the end of the associated event or to-do.

	 Either a positive or negative duration may be specified for the
	 "TRIGGER" property.  An alarm with a positive duration is
	 triggered after the associated start or end of the event or to-do.
	 An alarm with a negative duration is triggered before the
	 associated start or end of the event or to-do.

	 The "RELATED" property parameter is not valid if the value type of
	 the property is set to DATE-TIME (i.e., for an absolute date and
	 time alarm trigger).  If a value type of DATE-TIME is specified,
	 then the property value MUST be specified in the UTC time format.
	 If an absolute trigger is specified on an alarm for a recurring
	 event or to-do, then the alarm will only trigger for the specified
	 absolute DATE-TIME, along with any specified repeating instances.

	 If the trigger is set relative to START, then the "DTSTART"
	 property MUST be present in the associated "VEVENT" or "VTODO"
	 calendar component.  If an alarm is specified for an event with
	 the trigger set relative to the END, then the "DTEND" property or
	 the "DTSTART" and "DURATION " properties MUST be present in the
	 associated "VEVENT" calendar component.  If the alarm is specified
	 for a to-do with a trigger set relative to the END, then either
	 the "DUE" property or the "DTSTART" and "DURATION " properties
	 MUST be present in the associated "VTODO" calendar component.

	 Alarms specified in an event or to-do that is defined in terms of
	 a DATE value type will be triggered relative to 00:00:00 of the
	 user's configured time zone on the specified date, or relative to
	 00:00:00 UTC on the specified date if no configured time zone can
	 be found for the user.  For example, if "DTSTART" is a DATE value
	 set to 19980205 then the duration trigger will be relative to
	 19980205T000000 America/New_York for a user configured with the
	 America/New_York time zone.
```
*/
class Trigger extends Property {

	protected $name = 'TRIGGER';

	protected static $validValueTypes = [
		Duration::class,
		DateTime::class
	];
}
