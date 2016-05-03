<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Time Zone Identifier Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.3.1 RFC 5545 &sect;3.8.3.1}
```RFC
Purpose:  This property specifies the text value that uniquely
	 identifies the "VTIMEZONE" calendar component in the scope of an
	 iCalendar object.
```
```RFC
Description:  This is the label by which a time zone calendar
	 component is referenced by any iCalendar properties whose value
	 type is either DATE-TIME or TIME and not intended to specify a UTC
	 or a "floating" time.  The presence of the SOLIDUS character as a
	 prefix, indicates that this "TZID" represents an unique ID in a
	 globally defined time zone registry (when such registry is
	 defined).

			Note: This document does not define a naming convention for
			time zone identifiers.  Implementers may want to use the naming
			conventions defined in existing time zone specifications such
			as the public-domain TZ database [TZDB].  The specification of
			globally unique time zone identifiers is not addressed by this
			document and is left for future study.
```
*/
class Identifier extends TextProperty {

	protected $name = 'TZID';
}
