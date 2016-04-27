<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\URI;

class URL extends Property {
	
	protected $name = 'URL';
	
	protected static $validValueTypes = [
		URI::class
	];
}