<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\RecurrenceRule as RecurrenceRuleValue;

class RecurrenceRule extends Property {
	
	protected $name = 'RRULE';
	
	public static $validValueTypes = [
		RecurrenceRuleValue::class,
	];
}