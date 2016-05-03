<?php
	
namespace Battis\Calendar\iCalendar\RFC5545;

use Battis\Calendar\Parseable;
use Battis\Calendar\Saveable;

class Parameter implements Parseable, ContentLine /* TODO implements Saveable */ {
	
	/** @var string */
	protected $name;
	
	/** @var string */
	protected $value;
	
	public static function parse($input) {
		preg_match_all(
			'/' . PARAM . '/',
			$input,
			$parameterMatches,
			PREG_SET_ORDER
		);
		
		$parameters = [];
		foreach($parameterMatches as $match) {
			/* FIXME this probably isn't right */
			$parameters[$match[PARAMETER_NAME]] = new Parameter($match[PARAMETER_NAME], $match[PARAMETER_VALUE]);
		}
		
		return $parameters;
	}
	
	public function __construct($name, $value) {
		$this->$name = (string) $name;
		$this->setValue($value);
	}

	public function getName() {
		return $this->name;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($newValue) {
		$this->value = (string) $newValue;
	}
	
	public function save() {
		/* FIXME deal with quoted text */
		return $this->name . '=' . $this->value->save();
	}
}