<?php

namespace Battis\Calendar\iCalendar\RFC2445\Components;

use Battis\Calendar\iCalendar\RFC2445\Component;
use Battis\Calendar\iCalendar\RFC2445\Property;

use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\Contact;
use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\End;
use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\Duration;
use Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement\DateTimeStamp;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\Organizer;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\UniqueIdentifier;
use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\URL;

use Battis\Calendar\iCalendar\RFC2445\Properties\Relationship\Attendee;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\FreeBusyTime;
use Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard\RequestStatus;

class FreeBusy extends Component {
	
	protected static $validProperties = [
		Contact::class => Property::OPTIONAL_SINGLETON,
		Start::class => Property::OPTIONAL_SINGLETON,
		End::class => Property::OPTIONAL_SINGLETON,
		Duration::class => Property::OPTONAL_SINGLETON,
		DateTimeStamp::class => Property::OPTIONAL_SINGLETON,
		Organizer::class => Property::OPTIONAL_SINGLETON,
		UniqueIdentifier::class => Property::OPTIONAL_SINGLETON,
		URL::class => Property::OPTIONAL_SINGLETON,
		
		Attendee::class => Property::OPTIONAL_MULTIPLE,
		Comment::class => Property::OPTIONAL_MULTIPLE,
		FreeBusyTime::class => Property::OPTIONAL_MULTIPLE,
		RequestStatus::class => Property::OPTIONAL_MULTIPLE
	];
}