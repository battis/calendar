<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\Integer;

class IntegerProperty extends Property {
	
	protected static $validValueTypes = [
		Integer::class
	];
}