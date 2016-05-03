<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Description Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.5 RFC 5545 &sect;3.8.1.5}
```RFC
Purpose:  This property provides a more complete description of the
	 calendar component than that provided by the "SUMMARY" property.
```
```RFC
Description:  This property is used in the "VEVENT" and "VTODO" to
	 capture lengthy textual descriptions associated with the activity.

	 This property is used in the "VJOURNAL" calendar component to
	 capture one or more textual journal entries.

	 This property is used in the "VALARM" calendar component to
	 capture the display text for a DISPLAY category of alarm, and to
	 capture the body text for an EMAIL category of alarm.
```
*/
class Description extends TextProperty {

	protected $name = 'DESCRIPTION';
}
