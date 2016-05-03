<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\Float;

class FloatProperty extends Property {
	
	protected static $validValueTypes = [
		Float::class
	];
}