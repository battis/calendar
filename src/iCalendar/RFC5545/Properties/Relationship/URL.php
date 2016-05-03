<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\URI;

/**
Uniform Resource Locator Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4 RFC 5545 &sect;3.8.4}
```RFC
The following properties specify relationship information in calendar
components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4.6 RFC 5545 &sect;3.8.4.6}
```RFC
Purpose:  This property defines a Uniform Resource Locator (URL)
	 associated with the iCalendar object.
```
```RFC
Description:  This property may be used in a calendar component to
	 convey a location where a more dynamic rendition of the calendar
	 information associated with the calendar component can be found.
	 This memo does not attempt to standardize the form of the URI, nor
	 the format of the resource pointed to by the property value.  If
	 the URL property and Content-Location MIME header are both
	 specified, they MUST point to the same resource.
```
*/
class URL extends Property {

	protected $name = 'URL';

	protected static $validValueTypes = [
		URI::class
	];
}
