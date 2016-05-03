<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTimeProperty;

/**
Date-Time Created Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.7.1 RFC 5545 &sect;3.8.7.1}
```RFC
Purpose:  This property specifies the date and time that the calendar
	 information was created by the calendar user agent in the calendar
	 store.

			Note: This is analogous to the creation date and time for a
			file in the file system.
```
```RFC
Description:  This property specifies the date and time that the
	 calendar information was created by the calendar user agent in the
	 calendar store.
```
*/
class Created extends DateTimeProperty {

	protected $name = 'CREATED';
}
