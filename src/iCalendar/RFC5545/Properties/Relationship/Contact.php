<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Contact Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4.2 RFC 5545 &sect;3.8.4.2}
```RFC
Purpose:  This property is used to represent contact information or
	 alternately a reference to contact information associated with the
	 calendar component.
```
```RFC
Description:  The property value consists of textual contact
	 information.  An alternative representation for the property value
	 can also be specified that refers to a URI pointing to an
	 alternate form, such as a vCard [RFC2426], for the contact
	 information.
```
*/
class Contact extends TextProperty {

	protected $name = 'CONTACT';
}
