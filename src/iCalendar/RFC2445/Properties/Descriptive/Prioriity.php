<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Integer;

class Priority extends Property {
	
	protected $name = 'PRIORITY';
	
	public static $validValueTypes = [
		Integer::class
	];
}