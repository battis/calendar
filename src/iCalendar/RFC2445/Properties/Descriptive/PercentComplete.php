<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Integer;

class PercentComplete extends Property {
	
	protected $name = 'PERCENT-COMPLETE';
	
	public static $validValueTypes = [
		Integer::class
	];
}