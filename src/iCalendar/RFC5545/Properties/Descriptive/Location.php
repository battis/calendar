<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Location Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.1.7 RFC 5545 &sect;3.8.1.7}
```RFC
Purpose:  This property defines the intended venue for the activity
	 defined by a calendar component.
```
```RFC
Description:  Specific venues such as conference or meeting rooms may
	 be explicitly specified using this property.  An alternate
	 representation may be specified that is a URI that points to
	 directory information with more structured specification of the
	 location.  For example, the alternate representation may specify
	 either an LDAP URL [RFC4516] pointing to an LDAP server entry or a
	 CID URL [RFC2392] pointing to a MIME body part containing a
	 Virtual-Information Card (vCard) [RFC2426] for the location.
```
*/
class Location extends TextProperty {

	protected $name = 'LOCATION';
}
