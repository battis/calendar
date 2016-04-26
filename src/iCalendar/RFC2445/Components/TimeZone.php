<?php

namespace Battis\Calendar\iCalendar\RFC2445\Components;

use Battis\Calendar\iCalendar\RFC2445\Component;
use Battis\Calendar\iCalendar\RFC2445\Property;

use Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone\Identifier;
use Battis\Calendar\iCalendar\RFC2445\Properties\TimeZone\URL;
use Battis\Calendar\iCalendar\RFC2445\Properties\ChangeManagement\LastModified;

class TimeZone extends Component {
	
	protected static $validProperties = [
		Identifier::class => Property::REQUIRED_SINGLETON,
		
		LastModified::class => Property::OPTIONAL_SINGLETON,
		URL::class => Property::OPTIONAL_SINGLETON
	];
	
	protected static $validComponents = [
		Standard::class,
		Daylight::class
	];
	
	public function isValid(Component &$containingComponent = null) {
		if (parent::isValid()) {
			return false;
		}
		
		/* MUST have at least one standard or daylight subcomponent defined */
		return count($this->components) > 0;
	}
}