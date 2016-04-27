<?php

namespace Battis\Calendar;

interface Parseable {
	
	/**
	 * parse function.
	 * 
	 * @param mixed $input
	 * @return Parseable
	 */
	public static function parse($input);
}