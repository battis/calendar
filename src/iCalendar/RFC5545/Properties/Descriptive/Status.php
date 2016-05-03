<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Status Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.11 RFC 5545 &sect;3.8.1.11}
```RFC
Purpose:  This property defines the overall status or confirmation
	 for the calendar component.
```
```RFC
Description:  In a group-scheduled calendar component, the property
	 is used by the "Organizer" to provide a confirmation of the event
	 to the "Attendees".  For example in a "VEVENT" calendar component,
	 the "Organizer" can indicate that a meeting is tentative,
	 confirmed, or cancelled.  In a "VTODO" calendar component, the
	 "Organizer" can indicate that an action item needs action, is
	 completed, is in process or being worked on, or has been
	 cancelled.  In a "VJOURNAL" calendar component, the "Organizer"
	 can indicate that a journal entry is draft, final, or has been
	 cancelled or removed.
```
*/
class Status extends TextProperty {

	protected $name = 'STATUS';
}
