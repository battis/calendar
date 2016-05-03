<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties;

use Battis\Calendar\iCalendar\RFC5545\Values\DateTime;
use Battis\Calendar\iCalendar\RFC5545\Values\Date;

class DefaultDateTimeProperty extends DateTimeProperty {
		
	protected static $validValueTypes = [
		DateTime::class,
		Date::class
	];
}