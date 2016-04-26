<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\URI;

class URL extends Property {
	
	protected $name = 'TZURL';

	public static $validValueTypes = [
		URI::class
	];	
}