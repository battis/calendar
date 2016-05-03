<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties;

use Battis\Calendar\iCalendar\RFC5545\Property;
use Battis\Calendar\iCalendar\RFC5545\Values\Text;

class TextProperty extends Property {
	
	protected static $validValueTypes = [
		Text::class
	];
}