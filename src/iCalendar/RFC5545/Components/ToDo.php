<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Classification;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Completed;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\Created;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Description;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\DateTimeStamp;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\GeographicPosition;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\LastModified;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Location;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Organizer;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\PercentComplete;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Priority;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\RecurrenceID;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\SequenceNumber;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Status;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Summary;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\UniqueIdentifier;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\URL;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Due;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Duration;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Attachment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Attendee;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Categories;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Contact;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\ExceptionDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\ExceptionRule;
use Battis\Calendar\iCalendar\RFC5545\Properties\Nonstandard\RequestStatus;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\RelatedTo;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Resources;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceRule;

/**
To-Do Component

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.6 RFC 5545 &sect;3.6}
```RFC
   The body of the iCalendar object consists of a sequence of calendar
   properties and one or more calendar components.  The calendar
   properties are attributes that apply to the calendar object as a
   whole.  The calendar components are collections of properties that
   express a particular calendar semantic.  For example, the calendar
   component can specify an event, a to-do, a journal entry, time zone
   information, free/busy time information, or an alarm.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.6.2 RFC 5545 &sect;3.6.2}
```RFC
   Purpose:  Provide a grouping of calendar properties that describe a
      to-do.
```
```RFC
   Description:  A "VTODO" calendar component is a grouping of component
      properties and possibly "VALARM" calendar components that
      represent an action-item or assignment.  For example, it can be
      used to represent an item of work assigned to an individual; such
      as "turn in travel expense today".

      The "VTODO" calendar component cannot be nested within another
      calendar component.  However, "VTODO" calendar components can be
      related to each other or to a "VEVENT" or to a "VJOURNAL" calendar
      component with the "RELATED-TO" property.

      A "VTODO" calendar component without the "DTSTART" and "DUE" (or
      "DURATION") properties specifies a to-do that will be associated
      with each successive calendar date, until it is completed.
```
*/
class ToDo extends Component {
	
	/** @inheritDoc */
	// TODO review
	protected static $validPropertyTypes = [
		Classification::class => Property::OPTIONAL_SINGLETON,
		Completed::class => Property::OPTIONAL_SINGLETON,
		Created::class => Property::OPTIONAL_SINGLETON,
		Description::class => Property::OPTIONAL_SINGLETON,
		DateTimeStamp::class => Property::OPTIONAL_SINGLETON,
		Start::class => Property::OPTIONAL_SINGLETON,
		GeographicPosition::class => Property::OPTIONAL_SINGLETON,
		LastModified::class => Property::OPTIONAL_SINGLETON,
		Location::class => Property::OPTIONAL_SINGLETON,
		Organizer::class => Property::OPTIONAL_SINGLETON,
		PercentComplete::class => Property::OPTIONAL_SINGLETON,
		Priority::class => Property::OPTIONAL_SINGLETON,
		RecurrenceID::class => Property::OPTIONAL_SINGLETON,
		SequenceNumber::class => Property::OPTIONAL_SINGLETON,
		Status::class => Property::OPTIONAL_SINGLETON,
		Summary::class => Property::OPTIONAL_SINGLETON,
		UniqueIdentifier::class => Property::OPTIONAL_SINGLETON,
		URL::class => Property::OPTIONAL_SINGLETON,
		
		Due::class => Property::OPTIONAL_SINGLETON,
		Duration::class => Property::OPTIONAL_SINGLETON,
		
		Attachment::class => Property::OPTIONAL_MULTIPLE,
		Attendee::class => Property::OPTIONAL_MULTIPLE,
		Categories::class => Property::OPTIONAL_MULTIPLE,
		Comment::class => Property::OPTIONAL_MULTIPLE,
		Contact::class => Property::OPTIONAL_MULTIPLE,
		ExceptionDateTimes::class => Property::OPTIONAL_MULTIPLE,
		ExceptionRule::class => Property::OPTIONAL_MULTIPLE,
		RequestStatus::class => Property::OPTIONAL_MULTIPLE,
		RelatedTo::class => Property::OPTIONAL_MULTIPLE,
		Resources::class => Property::OPTIONAL_MULTIPLE,
		RecurrenceDateTimes::class => Property::OPTIONAL_MULTIPLE,
		RecurrenceRule::class => Property::OPTIONAL_MULTIPLE
	];
	
	protected static $validComponentTypes = [
		Alarm::class
	];
	
	public function isValid(\Battis\Calendar\Component &$containingComponent = null) {
		if (!parent::isValid()) {
			return false;
		}
		
		return (count($this->get(Due::class)) + count($this->get(Duration::class))) > 1;
	}
}