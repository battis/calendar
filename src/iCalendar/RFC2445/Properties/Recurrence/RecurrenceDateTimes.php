<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;
use Battis\Calendar\iCalendar\RFC2445\Values\Date;
use Battis\Calendar\iCalendar\RFC2445\Values\Period;

class RecurrenceDateTimes extends Property {
	
	protected $name = 'RDATE';
	
	public static $validValueTypes = [
		DateTime::class,
		Date::class,
		Period::class
	];
}