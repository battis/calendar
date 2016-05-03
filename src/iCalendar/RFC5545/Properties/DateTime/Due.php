<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Properties\DefaultDateTimeProperty;

/**
Date-Time Due Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.3 RFC 5545 &sect;3.8.2.3}
```RFC
Purpose:  This property defines the date and time that a to-do is
	 expected to be completed.
```
```RFC
Description:  This property defines the date and time before which a
	 to-do is expected to be completed.  For cases where this property
	 is specified in a "VTODO" calendar component that also specifies a
	 "DTSTART" property, the value type of this property MUST be the
	 same as the "DTSTART" property, and the value of this property
	 MUST be later in time than the value of the "DTSTART" property.
	 Furthermore, this property MUST be specified as a date with local
	 time if and only if the "DTSTART" property is also specified as a
	 date with local time.
```
*/
class Due extends DefaultDateTimeProperty {

	protected $name = 'DUE';
}
