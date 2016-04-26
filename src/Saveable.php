<?php
	
namespace Battis\Calendar;

interface Saveable {
	
	public function save();
	
	public function isValid();
}