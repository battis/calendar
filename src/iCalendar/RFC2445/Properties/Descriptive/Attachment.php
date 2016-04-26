<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\URI;
use Battis\Calendar\iCalendar\RFC2445\Values\Binary;

class Attachment extends Property {
	
	protected $name = 'ATTACH';
	
	public static $validValueTypes = [
		URI::class,
		Binary::class
	];
}