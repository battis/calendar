<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC2445\Properties\DateTimeProperty;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;
use Battis\Calendar\iCalendar\RFC2445\Values\Date;

class DefaultDateTimeProperty extends DateTimeProperty {
		
	public static $validValueTypes = [
		DateTime::class,
		Date::class
	];
}