<?php

namespace Battis\Calendar\iCalendar\RFC2445\Components;

use Battis\Calendar\iCalendar\RFC2445\Component;
use Battis\Calendar\iCalendar\RFC2445\Property;

use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Classification;
use Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement\Created;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Description;
use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement\DateTimeStamp;
use Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement\LastModified;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\Organizer;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\RecurrenceID;
use Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement\SequenceNumber;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Status;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Summary;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\UniqueIdentifier;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\URL;

use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Attachment;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\Attendee;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Categories;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\Contact;
use Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence\ExceptionDateTimes;
use Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence\ExceptionRule;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\RelatedTo;
use Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence\RecurrenceRule;
use Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard\RequestStatus;

class Journal extends Component {
	
	protected static $validProperties = [
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