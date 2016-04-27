<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\CalendarUserAddress;

class Organizer extends Property {
	
	protected $name = 'ORGANIZER';
	
	protected static $validValueTypes = [
		CalendarUserAddress::class
	];
}