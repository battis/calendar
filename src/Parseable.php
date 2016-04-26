<?php

namespace Battis\Calendar;

abstract class Parseable {

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
	public static function parse(&$input) {
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
}