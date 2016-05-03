<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\CalendarUserAddress;

/**
Organizer Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4.3 RFC 5545 &sect;3.8.4.3}
```RFC
Purpose:  This property defines the organizer for a calendar
	 component.
```
```RFC
Description:  This property is specified within the "VEVENT",
	 "VTODO", and "VJOURNAL" calendar components to specify the
	 organizer of a group-scheduled calendar entity.  The property is
	 specified within the "VFREEBUSY" calendar component to specify the
	 calendar user requesting the free or busy time.  When publishing a
	 "VFREEBUSY" calendar component, the property is used to specify
	 the calendar that the published busy time came from.

	 The property has the property parameters "CN", for specifying the
	 common or display name associated with the "Organizer", "DIR", for
	 specifying a pointer to the directory information associated with
	 the "Organizer", "SENT-BY", for specifying another calendar user
	 that is acting on behalf of the "Organizer".  The non-standard
	 parameters may also be specified on this property.  If the
	 "LANGUAGE" property parameter is specified, the identified
	 language applies to the "CN" parameter value.
```
*/
class Organizer extends Property {

	protected $name = 'ORGANIZER';

	protected static $validValueTypes = [
		CalendarUserAddress::class
	];
}
