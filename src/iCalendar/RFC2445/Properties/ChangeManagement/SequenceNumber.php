<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement;

use Battis\Calendar\iCalendar\RFC2445\Property;
use Battis\Calendar\iCalendar\RFC2445\Values\Integer;

class SequenceNumber extends Property {
	
	protected $name = 'SEQ';
	
	public static $validValueTypes = [
		Integer::class
	];
}