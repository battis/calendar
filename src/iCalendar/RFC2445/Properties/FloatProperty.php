<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Float;

class FloatProperty extends Property {
	
	protected static $validValueTypes = [
		Float::class
	];
}