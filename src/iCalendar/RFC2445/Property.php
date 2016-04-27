<?php
	
namespace Battis\Calendar\iCalendar\RFC2445;

require_once 'grammar.php';

use Battis\Calendar\Parseable;
use Battis\Calendar\Saveable;
use Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard\XProperty;
use Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard\IANAProperty;
use Battis\Calendar\iCalendar\Exceptions\PropertyException;

class Property implements Parseable /* TODO implements Saveable */ {
	
	const REQUIRED_SINGLETON = 'req_once';
	const REQUIRED_MULTIPLE = 'req';
	const OPTIONAL_SINGLETON = 'opt_once';
	const OPTIONAL_MULTIPLE = 'opt';
	
	/** @var string[] */
	protected static $validParameterTypes = [];
	
	/** @var string[] */
	protected static $validValueTypes = [];
	
	/** @var Value[] */
	protected static $validValues = [];
	
	/** @var string */
	protected $name;
	
	/** @var Parameter[] */
	protected $parameters;

	/** @var Value */
	protected $value;
	
	public static function parse($input) {
		preg_match('/' . CONTENTLINE . '/', $input, $contentLineMatches, PREG_OFFSET_CAPTURE);
		$propertyType = static::getPropertyClass($contentLineMatches[CONTENTLINE_NAME][REGEX_MATCH]);
		$value = $contentLineMatches[CONTENTLINE_VALUE][REGEX_MATCH];

		$parameters = Parameter::parse(substr(
				$input,
				strlen($contentLineMatches[CONTENTLINE_NAME][REGEX_MATCH]) + 1, // include ; or :
				$contentLineMatches[CONTENTLINE_VALUE][REGEX_OFFSET] -
					strlen($contentLineMatches[CONTENTLINE_NAME][REGEX_MATCH]) - 2 // include ; and :
			)
		);
		
		if (empty($propertyType::$validValueTypes)) {
			throw new PropertyException("Property `$propertyType` is missing a list valid value types");
		}
		$valueType = (
			isset($parameters['VALUE']) ?
				Value::getValueClass($parameters['VALUE']->getValue()) :
				$propertyType::$validValueTypes[0]
		);
		
		if ($propertyType == '\\' . XProperty::class || $propertyType == '\\' . IANAProperty::class) {
			return new $propertyType(
				$contentLineMatches[CONTENTLINE_NAME][REGEX_MATCH],
				$valueType::parse($value),
				...array_values($parameters)
			);
		}
		return new $propertyType(
			$valueType::parse($value),
			...array_values($parameters)
		);
	}
	
	public function __construct(...$param) {
		if (count($param) >= 1 && is_a($param[0], Value::class)) {
			$this->constructFromParameters(...$param);
		}
	}
	
	protected function constructFromParameters(Value $value, Parameter ...$parameters) {
		$this->setValue($value);
		$this->set(...$parameters);
	}

	protected static function getPropertyClass($propertySpecification) {
		$propertyClass = str_replace(' ', '', ucwords(preg_replace('/[^a-z0-9]/', ' ', strtoLower($propertySpecification))));
		switch ($propertyClass) {
			case 'Calscale':
			case 'Method':
			case 'Prodid':
			case 'Version':
				switch ($propertyClass) {
					case 'Calscale':
						$propertyClass = 'Scale';
						break;
					case 'Prodid':
						$propertyClass = 'ProductIdentifier';
						break;
				}
				$propertyClassDir = 'Calendar';
				break;
				
			case 'Attach':
			case 'Categories':
			case 'Class':
			case 'Comment':
			case 'Description':
			case 'Geo':
			case 'Location':
			case 'PercentComplete':
			case 'Priority':
			case 'Resources':
			case 'Status':
			case 'Summary':
				switch ($propertyClass) {
					case 'Attach':
						$propertyClass = 'Attachment';
						break;
					case 'Class':
						$propertyClass = 'Classification';
						break;
					case 'Geo':
						$propertyClass = 'GeographicLocation';
						break;
				}
				$propertyClassDir = 'Descriptive';
				break;
				
			case 'Completed':
			case 'Dtend':
			case 'Due':
			case 'Dtstart':
			case 'Duration':
			case 'Freebusy':
			case 'Transp':
				switch ($propertyClass) {
					case 'Dtend':
						$propertyClass = 'End';
						break;
					case 'Dtstart':
						$propertyClass = 'Start';
						break;
					case 'Freebusy':
						$propertyClass = 'FreeBusyTime';
						break;
					case 'Transp':
						$propertyClass = 'TimeTransparency';
						break;
				}
				$propertyClassDir = 'DateTime';
				break;
				
			case 'Tzid':
			case 'Tzname':
			case 'Tzoffsetfrom':
			case 'Tzoffsetto':
				switch ($propertyClass) {
					case 'Tzid':
						$propertyClass = 'Identifier';
						break;
					case 'Tzname':
						$propertyClass = 'Name';
						break;
					case 'Tzoffsetfrom':
						$propertyClass = 'OffsetFrom';
						break;
					case 'Tzoffsetto':
						$propertyClass = 'OffsetTo';
						break;
				}
				$propertyClassDir = 'TimeZone';
				break;
				
			case 'Attendee':
			case 'Contact':
			case 'Organizer':
			case 'RecurrenceId':
			case 'RelatedTo':
			case 'Url':
			case 'Uid':
				switch ($propertyClass) {
					case 'RecurrenceId':
						$propertyClass = 'RecurrenceID';
						break;
					case 'Url':
						$propertyClass = 'URL';
						break;
					case 'Uid':
						$propertyClass = 'UniqueIdentifier';
						break;
				}
				$propertyClassDir = 'Relationship';
				break;
				
			case 'Exdate':
			case 'Exrule':
			case 'Rdate':
			case 'Rrule':
				switch ($propertyClass) {
					case 'Exdate':
						$propertyClass = 'ExceptionDateTimes';
						break;
					case 'Exrule':
						$propertyClass = 'ExceptionRule';
						break;
					case 'Rdate':
						$propertyClass = 'RecurrenceDateTimes';
						break;
					case 'Rrule':
						$propertyClass = 'RecurrenceRule';
						break;
				}
				$propertyClassDir = 'Recurrence';
				break;
				
			case 'Action':
			case 'Repeat':
			case 'Trigger':
				switch ($propertyClass) {
					case 'Repeat':
						$propertyClass = 'RepeatCount';
						break;
				}
				$propertyClassDir = 'Alarm';
				break;
				
			case 'Created':
			case 'Dtstamp':
			case 'LastModified':
			case 'Sequence':
				switch ($propertyClass) {
					case 'Dtstamp':
						$propertyClass = 'DateTimeStamp';
						break;
					case 'Sequence':
						$propertyClass = 'SequenceNumber';
						break;
				}
				$propertyClassDir = 'ChangeManagement';
				break;
			
			case 'RequestStatus':
				$propertyClassDir = 'Nonstandard';
				break;
				
			default:
				if (preg_match('/^' . X_NAME . '$/', $propertySpecification)) {
					$propertyClass = 'XProperty';
					$propertyClassDir = 'Nonstandard';
				} elseif (preg_match('/^' . IANA_TOKEN . '$/', $propertySpecification)) {
					$propertyClass = 'IANAProperty';
					$propertyClassDir = 'Nonstandard';
				} else {
					throw new PropertyException("Unrecognized property specification `$propertySpecification`");
				}
		}
		return preg_replace('/^((.+\\\\)+)Property$/i', '\\\\$1', get_called_class()) . "Properties\\$propertyClassDir\\$propertyClass";
	}
			
	protected function setName($name) {
		$name = (string) $name;
		if ($this->isValidName($name)) {
			$this->name = $name;
			return true;
		}
		return false;
	}
	
	protected function isValidName($name) {
		/* TODO Determine a validation scheme */
		return true;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue(Value $value) {
		if ($this->isValidValue($value)) {
			$this->value = $value;
		}
	}
	
	protected function isValidValue(Value $value) {
		return !empty(static::$validValueTypes) && in_array(get_class($value), static::$validValueTypes) && (empty(static::$validValues) || in_array($value, static::$validValues));
	}

	public function get(string $parameterName) {
		if (isset($this->parameters[$parameter])) {
			return $this->parameters[$parameter];
		}
		return false;
	}
	
	public function set(Parameter ...$parameters) {
		$parametersWereAdded = true;
		foreach ($parameters as $parameter) {
			if ($this->isValidParameter($parameter)) {
				if(is_array($this->parameters) && in_array($parameter, $this->parameters)) {
					$parametersWereAdded = false;
				} else {
					$this->parameters[] = $parameter;
				}
			} else {
				throw new PropertyException('Invalid parameter `' . $parameter->getName() .'`');
			}
		}
		return $parametersWereAdded;
	}
	
	protected function isValidParameter($parameter) {
		/* TODO figure out validation scheme */
		return true;
	}
	
	public function save() {
		return $this->name .
			(empty($this->parameters) ? '' :
				';' . implode(';', array_map('Property::saveParameter', $this->parameters))
			) .
			$this->value->save();
	}
	
	private static function saveParameter(Parameter $p) {
		return $p->save();
	}
	
	public function isValid(Component &$containingComponent = null) {
		/* TODO figure out validation scheme */
		return true;
	}
}