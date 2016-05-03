<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Related To Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.4.5 RFC 5545 &sect;3.8.4.5}
```RFC
Purpose:  This property is used to represent a relationship or
	 reference between one calendar component and another.
```
```RFC
Description:  The property value consists of the persistent, globally
	 unique identifier of another calendar component.  This value would
	 be represented in a calendar component by the "UID" property.

	 By default, the property value points to another calendar
	 component that has a PARENT relationship to the referencing
	 object.  The "RELTYPE" property parameter is used to either
	 explicitly state the default PARENT relationship type to the
	 referenced calendar component or to override the default PARENT
	 relationship type and specify either a CHILD or SIBLING
	 relationship.  The PARENT relationship indicates that the calendar
	 component is a subordinate of the referenced calendar component.
	 The CHILD relationship indicates that the calendar component is a
	 superior of the referenced calendar component.  The SIBLING
	 relationship indicates that the calendar component is a peer of
	 the referenced calendar component.

	 Changes to a calendar component referenced by this property can
	 have an implicit impact on the related calendar component.  For
	 example, if a group event changes its start or end date or time,
	 then the related, dependent events will need to have their start
	 and end dates changed in a corresponding way.  Similarly, if a
	 PARENT calendar component is cancelled or deleted, then there is
	 an implied impact to the related CHILD calendar components.  This
	 property is intended only to provide information on the
	 relationship of calendar components.  It is up to the target
	 calendar system to maintain any property implications of this
	 relationship.
```
*/
class RelatedTo extends TextProperty {

	protected $name = 'RELATED-TO';
}
