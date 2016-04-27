<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Recurrence;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\RecurrenceRule;

class ExceptionRule extends Property {
	
	protected $name = 'EXRULE';
	
	protected static $validValueTypes = [
		RecurrenceRule::class,
	];
}