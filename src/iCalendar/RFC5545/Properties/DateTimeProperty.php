<?php
	
namespace Battis\Calendar\iCalendar\RFC5545\Properties;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\DateTime;

class DateTimeProperty extends Property {
	
	protected static $validValueTypes = [
		DateTime::class
	];
}