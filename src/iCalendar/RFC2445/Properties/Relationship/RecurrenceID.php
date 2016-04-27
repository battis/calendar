<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Relationship;

use Battis\Calendar\iCalendar\RFC2445\Properties\DefaultDateTimeProperty;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;
use Battis\Calendar\iCalendar\RFC2445\Values\Date;

class RecurrenceID extends DefaultDateTimeProperty {
	
	protected $name = 'RECURRENCE-ID';
}