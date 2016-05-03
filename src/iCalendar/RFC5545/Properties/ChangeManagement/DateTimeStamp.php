<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTimeProperty;

/**
Date-Time Stamp Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.7.2 RFC 5545 &sect;3.8.7.2}
```RFC
Purpose:  In the case of an iCalendar object that specifies a
	 "METHOD" property, this property specifies the date and time that
	 the instance of the iCalendar object was created.  In the case of
	 an iCalendar object that doesn't specify a "METHOD" property, this
	 property specifies the date and time that the information
	 associated with the calendar component was last revised in the
	 calendar store.
```
```RFC
Description:  The value MUST be specified in the UTC time format.

	 This property is also useful to protocols such as [2447bis] that
	 have inherent latency issues with the delivery of content.  This
	 property will assist in the proper sequencing of messages
	 containing iCalendar objects.

	 In the case of an iCalendar object that specifies a "METHOD"
	 property, this property differs from the "CREATED" and "LAST-
	 MODIFIED" properties.  These two properties are used to specify
	 when the particular calendar data in the calendar store was
	 created and last modified.  This is different than when the
	 iCalendar object representation of the calendar service
	 information was created or last modified.

	 In the case of an iCalendar object that doesn't specify a "METHOD"
	 property, this property is equivalent to the "LAST-MODIFIED"
	 property.
```
*/
class DateTimeStamp extends DateTimeProperty {

	protected $name = 'DTSTAMP';
}
