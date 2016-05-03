<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Comment Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.4 RFC 5545 &sect;3.8.1.4}
```RFC
Purpose:  This property specifies non-processing information intended
	 to provide a comment to the calendar user.
```
```RFC
Description:  This property is used to specify a comment to the
	 calendar user.
```
*/
class Comment extends TextProperty {

	protected $name = 'COMMENT';
}
