<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Calendar;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Calendar Scale Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7 RFC 5545 &sect;3.7}
```RFC
   The Calendar Properties are attributes that apply to the iCalendar
   object, as a whole.  These properties do not appear within a calendar
   component.  They SHOULD be specified after the "BEGIN:VCALENDAR"
   delimiter string and prior to any calendar component.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7.1 RFC 5545 &sect;3.7.1}
```RFC
   Purpose:  This property defines the calendar scale used for the
      calendar information specified in the iCalendar object.
```
```RFC
   Description:  This memo is based on the Gregorian calendar scale.
      The Gregorian calendar scale is assumed if this property is not
      specified in the iCalendar object.  It is expected that other
      calendar scales will be defined in other specifications or by
      future versions of this memo.
```
*/
class Scale extends TextProperty {
	
	/** @var string */
	protected $name = 'CALSCALE';
}