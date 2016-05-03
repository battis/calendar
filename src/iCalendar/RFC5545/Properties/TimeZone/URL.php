<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\URI;

/**
Time Zone URL Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.3.5 RFC 5545 &sect;3.8.3.5}
```RFC
Purpose:  This property provides a means for a "VTIMEZONE" component
	 to point to a network location that can be used to retrieve an up-
	 to-date version of itself.
```
```RFC
Description:  This property provides a means for a "VTIMEZONE"
	 component to point to a network location that can be used to
	 retrieve an up-to-date version of itself.  This provides a hook to
	 handle changes government bodies impose upon time zone
	 definitions.  Retrieval of this resource results in an iCalendar
	 object containing a single "VTIMEZONE" component and a "METHOD"
	 property set to PUBLISH.
```
*/
class URL extends Property {

	protected $name = 'TZURL';

	protected static $validValueTypes = [
		URI::class
	];
}
