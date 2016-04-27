<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties;

use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;
use Battis\Calendar\iCalendar\RFC2445\Values\Date;

class DefaultDateTimeProperty extends DateTimeProperty {
		
	protected static $validValueTypes = [
		DateTime::class,
		Date::class
	];
}