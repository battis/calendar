<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Time Zone Name Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.3 RFC 5545 &sect;3.8.3}
```RFC
The following properties specify time zone information in calendar
components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.3.2 RFC 5545 &sect;3.8.3.2}
```RFC
Purpose:  This property specifies the customary designation for a
	 time zone description.
```
```RFC
Description:  This property specifies a customary name that can be
	 used when displaying dates that occur during the observance
	 defined by the time zone sub-component.
```
*/
class Name extends TextProperty {

	protected $name = 'TZNAME';
}
