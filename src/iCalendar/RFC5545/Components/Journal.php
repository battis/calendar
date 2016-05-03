<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Classification;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\Created;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Description;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\DateTimeStamp;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\LastModified;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Organizer;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\RecurrenceID;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\SequenceNumber;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Status;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Summary;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\UniqueIdentifier;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\URL;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Attachment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Attendee;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Categories;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Contact;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\ExceptionDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\ExceptionRule;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\RelatedTo;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceRule;
use Battis\Calendar\iCalendar\RFC5545\Properties\Nonstandard\RequestStatus;

/**
Journal Component

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.6.3 RFC 5545 &sect;3.6.3}
```RFC
   Purpose:  Provide a grouping of component properties that describe a
      journal entry.
```
```RFC
   Description:  A "VJOURNAL" calendar component is a grouping of
      component properties that represent one or more descriptive text
      notes associated with a particular calendar date.  The "DTSTART"
      property is used to specify the calendar date with which the
      journal entry is associated.  Generally, it will have a DATE value
      data type, but it can also be used to specify a DATE-TIME value
      data type.  Examples of a journal entry include a daily record of
      a legislative body or a journal entry of individual telephone
      contacts for the day or an ordered list of accomplishments for the
      day.  The "VJOURNAL" calendar component can also be used to
      associate a document with a calendar date.

      The "VJOURNAL" calendar component does not take up time on a
      calendar.  Hence, it does not play a role in free or busy time
      searches -- it is as though it has a time transparency value of
      TRANSPARENT.  It is transparent to any such searches.

      The "VJOURNAL" calendar component cannot be nested within another
      calendar component.  However, "VJOURNAL" calendar components can
      be related to each other or to a "VEVENT" or to a "VTODO" calendar
      component, with the "RELATED-TO" property.
```
*/
class Journal extends Component {
	
	protected static $validPropertyTypes = [
		Classificatin:::class => Property::OPTIONAL_SINGLETON,
		Created::class => Property::OPTIONAL_SINGLETON,
		Description::class => Property::OPTIONAL_SINGLETON,
		Start::class => Property::OPTIONAL_SINGLETON,
		DateTimeStamp::class => Property::OPTIONAL_SINGLETON,
		LastModified::class => Property::OPTIONAL_SINGLETON,
		Organizer::class => Property::OPTIONAL_SINGLETON,
		RecurrenceID::class => Property::OPTIONAL_SINGLETON,
		SequenceNumber::class => Property::OPTIONAL_SINGLETON,
		Status::class => Property::OPTIONAL_SINGLETON,
		Summary::class => Property::OPTIONAL_SINGLETON,
		UniqueIdentifier::class => Property::OPTIONAL_SINGLETON,
		URL::class => Property::OPTIONAL_SINGLETON,

		Attachment::class => Property::OPTIONAL_MULTIPLE,
		Attendee::class => Property::OPTIONAL_MULTIPLE,
		Categories::class => Property::OPTIONAL_MULTIPLE,
		Comment::class => Property::OPTIONAL_MULTIPLE,
		Contact::class => Property::OPTIONAL_MULTIPLE,
		ExceptionDateTimes::class => Property::OPTIONAL_MULTIPLE,
		ExceptionRule::class => Property::OPTIONAL_MULTIPLE,
		RelatedTo::class => Property::OPTIONAL_MULTIPLE,
		RecurrenceDateTimes::class => Property::OPTIONAL_MULTIPLE,
		RecurrenceRule::class => Property::OPTIONAL_MULTIPLE,
		RequestStatus::class => Property::OPTIONAL_MULTIPLE
	];
}