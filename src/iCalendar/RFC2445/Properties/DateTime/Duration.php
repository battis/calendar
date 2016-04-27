<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Duration;

class Duration extends Property {
	
	protected $name = 'DURATION';
	
	protected static $validValueTypes = [
		Duration::class
	];
}