<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Calendar;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Method Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7 RFC 5545 &sect;3.7}
```RFC
   The Calendar Properties are attributes that apply to the iCalendar
   object, as a whole.  These properties do not appear within a calendar
   component.  They SHOULD be specified after the "BEGIN:VCALENDAR"
   delimiter string and prior to any calendar component.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7.2 RFC 5545 &sect;3.7.2}
```RFC
   Purpose:  This property defines the iCalendar object method
      associated with the calendar object.
```
```RFC
   Description:  When used in a MIME message entity, the value of this
      property MUST be the same as the Content-Type "method" parameter
      value.  If either the "METHOD" property or the Content-Type
      "method" parameter is specified, then the other MUST also be
      specified.

      No methods are defined by this specification.  This is the subject
      of other specifications, such as the iCalendar Transport-
      independent Interoperability Protocol (iTIP) defined by [2446bis].

      If this property is not present in the iCalendar object, then a
      scheduling transaction MUST NOT be assumed.  In such cases, the
      iCalendar object is merely being used to transport a snapshot of
      some calendar information; without the intention of conveying a
      scheduling semantic.
```
*/
class Method extends TextProperty {
	
	/** @var string */
	protected $name = 'METHOD';
}