<?php

namespace Battis\Calendar\iCalendar\RFC2445\Components;

use Battis\Calendar\iCalendar\RFC2445\Component;
use Battis\Calendar\iCalendar\RFC2445\Property;

use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone\OffsetTo;
use Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone\OffsetFrom;

use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence\RecurrenceRule;
use Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone\Name;


class Standard extends Component {
	
	protected static $validProperties = [
		Start::class => Property::REQUIRED_SINGLETON,
		OffsetTo::class => Property::REQUIRED_SINGLETON,
		OffsetFrom::class => Property::REQUIRED_SINGLETON,

		Comment::class => Property::OPTIONAL_MULTIPLE,
		RecurrenceDateTimes::class => Property::OPTIONAL_MULTIPLE,
		RecurrenceRule::class => Property::OPTIONAL_MULTIPLE,
		Name::class => Property::OPTIONAL_MULTIPLE
	];
}