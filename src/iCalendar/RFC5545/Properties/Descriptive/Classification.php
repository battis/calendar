<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Classification Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.3 RFC 5545 &sect;3.8.1.3}
```RFC
Purpose:  This property defines the access classification for a
	 calendar component.
```
```RFC
Description:  An access classification is only one component of the
	 general security system within a calendar application.  It
	 provides a method of capturing the scope of the access the
	 calendar owner intends for information within an individual
	 calendar entry.  The access classification of an individual
	 iCalendar component is useful when measured along with the other
	 security components of a calendar system (e.g., calendar user
	 authentication, authorization, access rights, access role, etc.).
	 Hence, the semantics of the individual access classifications
	 cannot be completely defined by this memo alone.  Additionally,
	 due to the "blind" nature of most exchange processes using this
	 memo, these access classifications cannot serve as an enforcement
	 statement for a system receiving an iCalendar object.  Rather,
	 they provide a method for capturing the intention of the calendar
	 owner for the access to the calendar component.  If not specified
	 in a component that allows this property, the default value is
	 PUBLIC.  Applications MUST treat x-name and iana-token values they
	 don't recognize the same way as they would the PRIVATE value.
```
*/
class Classification extends TextProperty {

	protected $name = 'CLASS';
}
