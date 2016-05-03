<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Time Transparency Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.7 RFC 5545 &sect;3.8.2.7}
```RFC
Purpose:  This property defines whether or not an event is
	 transparent to busy time searches.
```
```RFC
Description:  Time Transparency is the characteristic of an event
	 that determines whether it appears to consume time on a calendar.
	 Events that consume actual time for the individual or resource
	 associated with the calendar SHOULD be recorded as OPAQUE,
	 allowing them to be detected by free/busy time searches.  Other
	 events, which do not take up the individual's (or resource's) time
	 SHOULD be recorded as TRANSPARENT, making them invisible to free/
	 busy time searches.
```
*/
class TimeTransparency extends TextProperty {

	protected $name = 'TRANSP';
}
