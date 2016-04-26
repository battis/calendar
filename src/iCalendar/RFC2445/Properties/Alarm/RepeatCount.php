<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\Alarm;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Integer;

class RepeatCount extends Property {
	
	protected $name = 'REPEAT';
	
	public static $validValueTypes = [
		Integer::class
	];
}