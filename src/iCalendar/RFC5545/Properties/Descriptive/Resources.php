<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Resources Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.10 RFC 5545 &sect;3.8.1.10}
```RFC
Purpose:  This property defines the equipment or resources
	 anticipated for an activity specified by a calendar component.
```
```RFC
Description:  The property value is an arbitrary text.  More than one
	 resource can be specified as a COMMA-separated list of resources.
```
*/
class Resources extends TextProperty {

	protected $name = 'RESOURCES';
}
