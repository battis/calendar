<?php
	
namespace Battis\Calendar\iCalendar\RFC2445;

require_once __DIR__ . '/grammar.php';

use Battis\Calendar\Parseable;
use Battis\Calendar\Saveable;
use Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard\XProperty;
use Battis\Calendar\Exceptions\ParseableException;
use Battis\Calendar\iCalendar\Exceptions\ComponentException;

abstract class Component extends Parseable /* TODO implements Saveable */ {

	/** @var string */
	protected static $buffer = null;
	
	/** @var string For debugging */
	protected static $contentLine = null;
	
	/** @var Component For debugging */
	protected static $componentBeingParsed = null;
			
	/** @var Property[] */
	protected $properties = [];
	
	/** @var Component[] */
	protected $components = [];

	/** @var string[] */
	protected static $validComponents = [];
	
	/** @var string[] */
	protected static $validProperties = [];
	
	/**
	 * @pre $stream is a valid input stream
	 * @param resource $stream
	 * @return Component
	 */
	protected static function parseStream(&$stream) {
		$createdComponentClass = get_called_class();
		$component = new $createdComponentClass();
		static::$componentBeingParsed =& $component;
		while ($contentLine = static::nextContentLine($stream)) {
			preg_match('/' . CONTENTLINE . '/', $contentLine, $match);
			if (!isset($match[CONTENTLINE_NAME])) {
			}
			$name = $match[CONTENTLINE_NAME];
			if ($name === 'BEGIN') {
				$componentClass = static::getComponentClass($match[CONTENTLINE_VALUE]);
				$component->add($componentClass::parse($stream));
			} elseif ($name === 'END') {
				return $component;
			} else {
				$component->set(Property::parse($contentLine));
			}
		}
		return $component;
	}
	
	protected static function getComponentClass($componentSpecification) {
		$componentClass = ucwords(strtolower(preg_replace('/^v(.+)$/i', '$1', $componentSpecification)));
		switch ($componentClass) {
			case 'Freebusy':
				$componentClass = 'FreeBusy';
				break;
			case 'Timezone':
				$componentClass = 'TimeZone';
				break;
			case 'Todo':
				$componentClass = 'ToDo';
				break;
		}
		return "Battis\\Calendar\\iCalendar\\RFC2445\\Components\\$componentClass";
	}
	
	public static function nextContentLine(&$stream) {
		if (!is_resource($stream)) {
			throw new ParseableException('$stream is expected to be a resource');
		}

		$contentLine = null;
		$wrapped = true;
		
		do {
			/* refill the buffer */
			if (empty(static::$buffer)) {
				static::$buffer = stream_get_line($stream, 80, CRLF);
			}
			
			if (static::$buffer) {
				if (empty($contentLine)) {
					$contentLine = static::$buffer;
					static::$buffer = null;
				} elseif (preg_match('/^[' . WSP . '](.*)$/', static::$buffer, $match)) {
					$contentLine .= $match[1];
					static::$buffer = null;
				} else {
					$wrapped = false;
				}
			}
			
		} while ($wrapped && static::$buffer !== false);
		
		static::$contentLine =& $contentLine;
		return $contentLine;
	}

	public function get(string $name) {
		$properties = array();
		foreach ($this->properties as $property) {
			if ($property->getName() == $name) {
				$properties[] = $property;
			}
		}
		return $properties;
	}
	
	public function set(Property ...$properties) {
		$propertyWasSet = true;
		foreach($properties as $property) {
			if ($this->isValidProperty($property)) {
				if (!in_array($property, $this->properties)) {
					$this->properties[] = $property;
				} else {
					$propertyWasSet = false;
				}
			} else {
				throw new ComponentException('Invalid property `' . $property->getName() . '`');
			}
		}
		return $propertyWasSet;
	}
		
	protected function isValidProperty(Property $property) {
		return is_a($property, XProperty::class) || array_key_exists(get_class($property), static::$validProperties);
	}
	
	public function getComponents(string ...$componentTypes) {
		$components = array();
		foreach ($this->components as $component) {
			foreach ($componentTypes as $componentType) {
				if (is_a($component, $componentType)) {
					$components[] = $component;
					break;
				}
			}
		}
		return $components;
	}
	
	public function add(Component ...$components) {
		$componentWasAdded = true;
		foreach($components as $component) {
			if ($this->isValidComponent($component)) {
				if (!in_array($component, $this->components)) {
					$this->components[] = $component;
				} else {
					$componentWasAdded = false;
				}
			} else {
				throw new ComponentException('Invalid component `' . get_class(Component) . '`');
			}
		}
		return $componentWasAdded;
	}
	
	protected function isValidComponent(Component $component) {
		return in_array(get_class($component), static::$validComponents);
	}
	
	public function isValid(Component &$containingComponent = null) {
		/* validate all subcomponents */
		foreach($this->components as $component) {
			if (!$component->isValid($this)) {
				return false;
			}
		}
		
		/* test for required properties */
		foreach(array_filter(static::$validProperties, array($this, 'isRequiredProperty')) as $propertyName => $requirement) {
			if (empty($this->get($propertyName))) {
				return false;
			}
		}
		
		/* test for singleton properties */
		foreach(array_filter(static::validProperties, array($this, 'isSingletonProperty')) as $propertyName => $requirement) {
			if (count($this->get($propertyName)) > 1) {
				return false;
			}
		}
		
		/* validate all properties */
		foreach($this->properties as $property) {
			if (!$property->isValid($this)) {
				return false;
			}
		}
		
		return true;
	}
	
	protected function isRequiredProperty($requirement) {
		return $requirement === Property::REQUIRED_SINGLETON || $requirement === Property::REQUIRED_MULTIPLE;
	}
	
	protected function isSingletonProperty($requirement) {
		return $requirement === Property::REQUIRED_SINGLETON || $requirement === Property::OPTONAL_SINGLETON;
	}
}