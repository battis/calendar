<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;
use Battis\Calendar\iCalendar\RFC2445\Values\Date;

class RecurrenceID extends Property {
	
	protected $name = 'RECURRENCE-ID';
	
	public static $validValueTypes = [
		DateTime::class,
		Date::class
	];
}