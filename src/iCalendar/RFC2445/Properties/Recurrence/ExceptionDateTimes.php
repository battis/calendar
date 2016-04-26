<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;
use Battis\Calendar\iCalendar\RFC2445\Values\Date;

class ExceptionDateTimes extends Property {
	
	protected $name = 'EXDATE';
	
	public static $validValueTypes = [
		DateTime::class,
		Date::class
	];
}