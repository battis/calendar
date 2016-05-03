<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement;

use Battis\Calendar\iCalendar\RFC5545\Properties\IntegerProperty;

/**
Sequence Number Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.7 RFC 5545 &sect;3.8.7}
```RFC
The following properties specify change management information in
calendar components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.7.4 RFC 5545 &sect;3.8.7.4}
```RFC
Purpose:  This property defines the revision sequence number of the
	 calendar component within a sequence of revisions.
```
```RFC
Description:  When a calendar component is created, its sequence
	 number is 0.  It is monotonically incremented by the "Organizer's"
	 CUA each time the "Organizer" makes a significant revision to the
	 calendar component.

	 The "Organizer" includes this property in an iCalendar object that
	 it sends to an "Attendee" to specify the current version of the
	 calendar component.

	 The "Attendee" includes this property in an iCalendar object that
	 it sends to the "Organizer" to specify the version of the calendar
	 component to which the "Attendee" is referring.

	 A change to the sequence number is not the mechanism that an
	 "Organizer" uses to request a response from the "Attendees".  The
	 "RSVP" parameter on the "ATTENDEE" property is used by the
	 "Organizer" to indicate that a response from the "Attendees" is
	 requested.

	 Recurrence instances of a recurring component MAY have different
	 sequence numbers.
```
*/
class SequenceNumber extends IntegerProperty {

	protected $name = 'SEQ';
}
