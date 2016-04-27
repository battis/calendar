<?php

namespace Battis\Calendar\iCalendar\RFC2445\Components;

use Battis\Calendar\iCalendar\RFC2445\Component;
use Battis\Calendar\iCalendar\RFC2445\Property;

use Battis\Calendar\iCalendar\RFC2445\Properties\Alarm\Action;
use Battis\Calendar\iCalendar\RFC2445\Properties\Alarm\Repeat;
use Battis\Calendar\iCalendar\RFC2445\Properties\Alarm\Trigger;
use Battis\Calendar\iCalendar\RFC2445\Properties\DateTime\Duration;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Attachment;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Summary;
use Battis\Calendar\iCalendar\RFC2445\Properties\Descriptive\Attendee;

class Alarm extends Component {
	
	const AUDIO_ACTION = 'AUDIO';
	const DISPLAY_ACTION = 'DISPLAY';
	const EMAIL_ACTION = 'EMAIL';
	
	protected static $validPropertyTypes = [
		Action::class => Property::REQUIRED_SINGLETON,
		Trigger::class => Property::REQUIRED_SINGLETON
	];
	
	protected $instanceValidPropertTypes = [];
	
	protected function isValidProperty(Property $property) {
		/* FIXME this isn't right */
		return true;
	}
}