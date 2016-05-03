<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\CalendarUserAddress;

/**
Attendee Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4.1 RFC 5545 &sect;3.8.4.1}
```RFC
Purpose:  This property defines an "Attendee" within a calendar
	 component.
```
```RFC
Description:  This property MUST only be specified within calendar
	 components to specify participants, non-participants, and the
	 chair of a group-scheduled calendar entity.  The property is
	 specified within an "EMAIL" category of the "VALARM" calendar
	 component to specify an email address that is to receive the email
	 type of iCalendar alarm.

	 The property parameter "CN" is for the common or displayable name
	 associated with the calendar address; "ROLE", for the intended
	 role that the attendee will have in the calendar component;
	 "PARTSTAT", for the status of the attendee's participation;
	 "RSVP", for indicating whether the favor of a reply is requested;
	 "CUTYPE", to indicate the type of calendar user; "MEMBER", to
	 indicate the groups that the attendee belongs to; "DELEGATED-TO",
	 to indicate the calendar users that the original request was
	 delegated to; and "DELEGATED-FROM", to indicate whom the request
	 was delegated from; "SENT-BY", to indicate whom is acting on
	 behalf of the "ATTENDEE"; and "DIR", to indicate the URI that
	 points to the directory information corresponding to the attendee.
	 These property parameters can be specified on an "ATTENDEE"
	 property in either a "VEVENT", "VTODO", or "VJOURNAL" calendar
	 component.  They MUST NOT be specified in an "ATTENDEE" property
	 in a "VFREEBUSY" or "VALARM" calendar component.  If the
	 "LANGUAGE" property parameter is specified, the identified
	 language applies to the "CN" parameter.

	 A recipient delegated a request MUST inherit the "RSVP" and "ROLE"
	 values from the attendee that delegated the request to them.

	 Multiple attendees can be specified by including multiple
	 "ATTENDEE" properties within the calendar component.
```
*/
class Attendee extends Property {

	protected $name = 'ATTENDEE';

	protected static $validValueTypes = [
		CalendarUserAddress::class
	];
}
