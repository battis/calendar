<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\URI;

class URL extends Property {
	
	protected $name = 'TZURL';

	protected static $validValueTypes = [
		URI::class
	];	
}