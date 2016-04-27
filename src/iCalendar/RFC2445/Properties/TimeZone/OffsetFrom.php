<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\UTCOffset;

class OffsetFrom extends Property {
	
	protected $name = 'TZOFFSETFROM';
	
	protected static $validValueTypes = [
		UTCOffset::class
	];
}