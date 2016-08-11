<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone\OffsetTo;
use Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone\OffsetFrom;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceRule;
use Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone\Name;

class Standard extends Component
{
    protected static $validPropertyTypes = [
        Start::class => Property::REQUIRED_SINGLETON,
        OffsetTo::class => Property::REQUIRED_SINGLETON,
        OffsetFrom::class => Property::REQUIRED_SINGLETON,

        Comment::class => Property::OPTIONAL_MULTIPLE,
        RecurrenceDateTimes::class => Property::OPTIONAL_MULTIPLE,
        RecurrenceRule::class => Property::OPTIONAL_MULTIPLE,
        Name::class => Property::OPTIONAL_MULTIPLE
    ];
}
