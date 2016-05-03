<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Summary Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.12 RFC 5545 &sect;3.8.1.12}
```RFC
Purpose:  This property defines a short summary or subject for the
	 calendar component.
```
```RFC
Description:  This property is used in the "VEVENT", "VTODO", and
	 "VJOURNAL" calendar components to capture a short, one-line
	 summary about the activity or journal entry.

	 This property is used in the "VALARM" calendar component to
	 capture the subject of an EMAIL category of alarm.
```
*/
class Summary extends TextProperty {

	protected $name = 'SUMMARY';
}
