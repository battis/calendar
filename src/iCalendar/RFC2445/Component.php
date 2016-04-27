<?php
	
namespace Battis\Calendar\iCalendar\RFC2445;

require_once 'grammar.php';

use Battis\Calendar\Parseable;
use Battis\Calendar\Saveable;
use Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard\XProperty;
use Battis\Calendar\Exceptions\ParseableException;
use Battis\Calendar\iCalendar\Exceptions\ComponentException;

abstract class Component implements Parseable /* TODO implements Saveable */ {

	/** @var string */
	protected static $buffer = null;
	
	/** @var string For debugging */
	protected static $contentLine = null;
	
	/** @var Component For debugging */
	protected static $componentBeingParsed = null;
			
	/** @var Property[] */
	protected $properties;
	
	/** @var Component[] */
	protected $components;

	/** @var string[] */
	protected static $validComponentTypes = [];
	
	/** @var string[] */
	protected static $validPropertyTypes = [];
	
	/**
	 * Parse an input string or stream to create an object
	 * 
	 * The check to see if the file exists on another domain is {@link
	 * http://www.brightcherry.co.uk/scribbles/php-check-if-file-exists-on-different-domain/
	 * modeled on BrightCherry's example}
	 *
	 * Thanks to {@link https://evertpot.com/222/ Evert Pot} for the example of
	 * reading a string as a stream.
	 *
	 * @param string|resource $input A filename, URL or literal string to be parsed.
	 * @return Parseable
	 */
	public static function parse($input) {
		$stream = null;
		
		if (is_string($input)) {
			if (
				file_exists($input) ||
				(
					preg_match('%.+://.+%', $input) &&
					strpos(get_headers($input, 1)[0], '404') === false
				)
			) {
				$stream = fopen($input, 'r');
			} else {
				ini_set('auto_detect_line_endings', true);
				$stream = fopen('php://memory', 'r+');
				fwrite($stream, $input);
				rewind($stream);
			}
		} elseif (is_resource($input)) {
			$stream =& $input;
		} else {
			throw new ParseableException('Cannot parse `' . (is_object($input) ? get_class($input) : gettype($input)) . '`');
		}
		
		return static::parseStream($stream);
	}
	
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

	public function get($propertyClass) {
		$matchingProperties = array();
		if (is_array($this->properties)) {
			foreach ($this->properties as $property) {
				if ($property->getName() == $name) {
					$matchingProperties[] = $property;
				}
			}
			return $matchingProperties;
		}
		return false;
	}
	
	public function set(Property ...$properties) {
		$propertyWasSet = true;
		foreach($properties as $property) {
			if ($this->isValidProperty($property)) {
				if (is_array($this->properties) && in_array($property, $this->properties)) {
					$propertyWasSet = false;
				} else {
					$this->properties[] = $property;
				}
			} else {
				throw new ComponentException('Invalid property `' . $property->getName() . '`');
			}
		}
		return $propertyWasSet;
	}
		
	protected function isValidProperty(Property $property) {
		return is_a($property, XProperty::class) || array_key_exists(get_class($property), static::$validPropertyTypes);
	}
	
	public function getComponents(string ...$componentTypes) {
		$components = array();
		if (is_array($this->components)) {
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
		return false;
	}
	
	public function add(Component ...$components) {
		$componentWasAdded = true;
		foreach($components as $component) {
			if ($this->isValidComponent($component)) {
				if (is_array($this->components) && in_array($component, $this->components)) {
					$componentWasAdded = false;
				} else {
					$this->components[] = $component;
				}
			} else {
				throw new ComponentException('Invalid component `' . get_class(Component) . '`');
			}
		}
		return $componentWasAdded;
	}
	
	protected function isValidComponent(Component $component) {
		return in_array(get_class($component), static::$validComponentTypes);
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