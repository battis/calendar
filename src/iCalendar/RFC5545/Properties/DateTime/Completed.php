<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTimeProperty;

/**
Date-Time Completed Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.2.1 RFC 5545 &sect;3.8.2.1}
```RFC
Purpose:  This property defines the date and time that a to-do was
	 actually completed.
```
```RFC
Description:  This property defines the date and time that a to-do
	 was actually completed.
```
*/
class Completed extends DateTimeProperty {

	protected $name = 'COMPLETED';
}
