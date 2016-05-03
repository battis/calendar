<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\IntegerProperty;

/**
Percent Complete Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.8 RFC 5545 &sect;3.8.1.8}
```RFC
Purpose:  This property is used by an assignee or delegatee of a
	 to-do to convey the percent completion of a to-do to the
	 "Organizer".
```
```RFC
Description:  The property value is a positive integer between 0 and
	 100.  A value of "0" indicates the to-do has not yet been started.
	 A value of "100" indicates that the to-do has been completed.
	 Integer values in between indicate the percent partially complete.

	 When a to-do is assigned to multiple individuals, the property
	 value indicates the percent complete for that portion of the to-do
	 assigned to the assignee or delegatee.  For example, if a to-do is
	 assigned to both individuals "A" and "B".  A reply from "A" with a
	 percent complete of "70" indicates that "A" has completed 70% of
	 the to-do assigned to them.  A reply from "B" with a percent
	 complete of "50" indicates "B" has completed 50% of the to-do
	 assigned to them.
```
*/
class PercentComplete extends IntegerProperty {

	protected $name = 'PERCENT-COMPLETE';
}
