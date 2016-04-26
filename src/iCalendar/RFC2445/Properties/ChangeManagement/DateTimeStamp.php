<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement;

use Battis\Calendar\iCalendar\RFC2445\Properties\DateTimeProperty;
use Battis\Calendar\iCalendar\RFC2445\Values\DateTime;

class DateTimeStamp extends DateTimeProperty {
	
	protected $name = 'DTSTAMP';
}