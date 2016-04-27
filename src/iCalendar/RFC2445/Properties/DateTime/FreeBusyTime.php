<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Period;

class Duration extends Property {
	
	protected $name = 'FREEBUSY';

	protected static $validValueTypes = [
		Period::class
	];	
}