<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Float;

class GeographicPosition extends Property {
	
	protected $name = 'GEO';
	
	public static $validValueTypes = [
		Float::class
	];
}