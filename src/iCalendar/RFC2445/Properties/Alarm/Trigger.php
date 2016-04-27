<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\Alarm;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Duration;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;

class Trigger extends Property {
	
	protected $name = 'TRIGGER';
	
	protected static $validValueTypes = [
		Duration::class,
		DateTime::class
	];
}