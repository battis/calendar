<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;

class DateTimeProperty extends Property {
	
	protected static $validValueTypes = [
		DateTime::class
	];
}