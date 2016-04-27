<?php

/* FIXME at the moment, a calendar can NOT be created from a stream at the start of a valid iCalendar file, because we need to already be "inside" the BEGIN:VCALENDAR line */

namespace Battis\Calendar\iCalendar\RFC2445\Components;

use Battis\Calendar\iCalendar\RFC2445\Component;
use Battis\Calendar\iCalendar\RFC2445\Property;

use Battis\Calendar\iCalendar\RFC2445\Properties\Calendar\ProductIdentifier;
use Battis\Calendar\iCalendar\RFC2445\Properties\Calendar\Version;
use Battis\Calendar\iCalendar\RFC2445\Properties\Calendar\Scale;
use Battis\Calendar\iCalendar\RFC2445\Properties\Calendar\Method;

use Battis\Calendar\Exceptions\CalendarException;

class Calendar extends Component {
	
	/** @inheritdoc */
	protected static $validPropertyTypes = [
		ProductIdentifier::class => Property::REQUIRED_SINGLETON,
		Version::class => Property::REQUIRED_SINGLETON,

		Scale::class => Property::OPTIONAL_SINGLETON,
		Method::class => Property::OPTIONAL_SINGLETON
	];
	
	/** @inheritdoc */
	protected static $validComponentTypes = [
		Event::class,
		ToDo::class,
		Journal::class,
		FreeBusy::class,
		TimeZone::class
	];
	
	protected static function parseStream(&$stream) {
		do {
			$contentLine = static::nextContentLine($stream);
		} while ($contentLine && $contentLine != 'BEGIN:VCALENDAR');
		return parent::parseStream($stream);
	}
	
	/** @inheritdoc */
	public function isValid(\Battis\Calendar\iCalendar\RFC2445\Component &$containingComponent = null) {
		if (!parent::isValid($containingComponent)) {
			return false;
		}
		
		return count($this->components) > 0;
	}
}