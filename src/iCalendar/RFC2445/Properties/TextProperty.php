<?php

namespace Battis\Calendar\iCalendar\RFC2445\Properties;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Text;

class TextProperty extends Property {
	
	public static $validValueTypes = [
		Text::class
	];
}