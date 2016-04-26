<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties\DateTime;

use Battis\Calendar\iCalendar\RFC2445\Values\Duration;

class Duration extends DefaultDateTimeProperty {
	
	protected $name = 'DURATION';
	
	public static $validValueTypes = [
		Duration::class
	];
}