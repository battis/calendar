<?php
	
namespace Battis\Calendar\iCalendar\RFC2445;

use Battis\Calendar\Parseable;
use Battis\Calendar\Saveable;
use Battis\Calendar\iCalendar\Exceptions\ValueException;

abstract class Value extends Parseable /* TODO implements Saveable */ {
	
	/** @var string */
	protected $name;
	
	protected $value;
	
	public static function parse(&$input) {
		/* FIXME take a closer look at this hack */
		$valueType = get_called_class();
		$value = new $valueType();
		$value->set($input);
		return $value;
	}
	
	protected static function parseStream(&$input) {
		/* TODO find nicer wording for this exception */
		throw new ParseableException('It is not meaningful to parse a value from a stream');
	}
	
	public static function getValueClass($valueSpecification) {
		$valueClass = str_replace(' ', '', ucwords(preg_replace('/[^a-z0-9]/', ' ', strtoLower($valueSpecification))));
		switch($valueClass) {
			case 'CalAddress':
				$valueClass = 'CalendarUserAddress';
				break;
			case 'Period':
				$valueClass = 'PeriodOfTime';
				break;
			case 'Recur':
				$valueClass = 'RecurrenceRule';
				break;
			case 'Uri':
				$valueClass = 'URI';
				break;
			case 'UtcOffset':
				$valueClass = 'UTCOffset';
				break;
		}
		return preg_replace('/^((.+\\\\)+)Value$/i', '\\\\$1', get_called_class()) . "Values\\$valueClass";
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function get() {
		return $this->value();
	}
	
	public function set($newValue) {
		if ($this->isValidValue($newValue)) {
			$oldValue = $this->value;
			$this->value = $newValue;
			return $oldValue;
		} else {
			throw new ValueException("Invalid value '$newValue'");
		}
	}
	
	protected function isValidValue($value) {
		/* FIXME this probably isn't right! */
		return true;
	}
}