<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Categories Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.2 RFC 5545 &sect;3.8.1.2}
```RFC
Purpose:  This property defines the categories for a calendar
	 component.
```
```RFC
Description:  This property is used to specify categories or subtypes
	 of the calendar component.  The categories are useful in searching
	 for a calendar component of a particular type and category.
	 Within the "VEVENT", "VTODO", or "VJOURNAL" calendar components,
	 more than one category can be specified as a COMMA-separated list
	 of categories.
```
*/
class Categories extends TextProperty {

	protected $name = 'CATEGORIES';
}
