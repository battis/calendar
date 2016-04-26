<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Values;

require_once __DIR__ . '/../grammar.php';

use Battis\Calendar\iCalendar\RFC2445\Value;

class DateTime extends Value {

	protected $name = 'DATE-TIME';	
}