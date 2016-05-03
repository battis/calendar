<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Calendar;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Product Identifier Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7 RFC 5545 &sect;3.7}
```RFC
   The Calendar Properties are attributes that apply to the iCalendar
   object, as a whole.  These properties do not appear within a calendar
   component.  They SHOULD be specified after the "BEGIN:VCALENDAR"
   delimiter string and prior to any calendar component.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.7.3 RFC 5545 &sect;3.7.3}
```RFC
   Purpose:  This property specifies the identifier for the product that
      created the iCalendar object.
```
```RFC
   Description:  The vendor of the implementation SHOULD assure that
      this is a globally unique identifier; using some technique such as
      an FPI value, as defined in [ISO.9070.1991].

      This property SHOULD NOT be used to alter the interpretation of an
      iCalendar object beyond the semantics specified in this memo.  For
      example, it is not to be used to further the understanding of non-
      standard properties.
```
*/
class ProductIdentifier extends TextProperty {
	
	/** @var string */
	protected $name = 'PRODID';
}