<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTimeProperty;

/**
Last Modified Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.7.3 RFC 5545 &sect;3.8.7.3}
```RFC
Purpose:  This property specifies the date and time that the
	 information associated with the calendar component was last
	 revised in the calendar store.

			Note: This is analogous to the modification date and time for a
			file in the file system.
```
```RFC
Description:  The property value MUST be specified in the UTC time
	 format.
```
*/
class LastModified extends DateTimeProperty {

	protected $name = 'LAST-MODIFIED';
}
