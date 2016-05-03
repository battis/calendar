<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Calendar;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Version Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7 RFC 5545 &sect;3.7}
```RFC
   The Calendar Properties are attributes that apply to the iCalendar
   object, as a whole.  These properties do not appear within a calendar
   component.  They SHOULD be specified after the "BEGIN:VCALENDAR"
   delimiter string and prior to any calendar component.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7.3 RFC 5545 &sect;3.7.3}
```RFC
   Purpose:  This property specifies the identifier corresponding to the
      highest version number or the minimum and maximum range of the
      iCalendar specification that is required in order to interpret the
      iCalendar object.
```
```RFC
   Description:  A value of "2.0" corresponds to this memo.
```
*/
class Version extends TextProperty {
	
	/** @inheritDoc */
	protected $name = 'VERSION';
}