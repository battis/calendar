<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\URI;
use Battis\Calendar\iCalendar\RFC5545\Values\Binary;

/**
Attachment Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.1 RFC 5545 &sect;3.8.1.1}
```RFC
Purpose:  This property provides the capability to associate a
	 document object with a calendar component.
```
```RFC
Description:  This property is used in "VEVENT", "VTODO", and
	 "VJOURNAL" calendar components to associate a resource (e.g.,
	 document) with the calendar component.  This property is used in
	 "VALARM" calendar components to specify an audio sound resource or
	 an email message attachment.  This property can be specified as a
	 URI pointing to a resource or as inline binary encoded content.

	 When this property is specified as inline binary encoded content,
	 calendar applications MAY attempt to guess the media type of the
	 resource via inspection of its content if and only if the media
	 type of the resource is not given by the "FMTTYPE" parameter.  If
	 the media type remains unknown, calendar applications SHOULD treat
	 it as type "application/octet-stream".
```
*/class Attachment extends Property {

	protected $name = 'ATTACH';

	protected static $validValueTypes = [
		URI::class,
		Binary::class
	];
}
