<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Integer;

class IntegerProperty extends Property {
	
	protected static $validValueTypes = [
		Integer::class
	];
}