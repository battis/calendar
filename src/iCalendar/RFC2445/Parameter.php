<?php
	
namespace Battis\Calendar\iCalendar\RFC2445;

use Battis\Calendar\Saveable;

class Parameter /* TODO implements Saveable */ {
	
	/** @var string */
	protected $name;
	
	/** @var string */
	protected $value;
	
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