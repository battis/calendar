<?php

namespace Battis\Calendar\iCalendar\RFC5545\Values;

define('ESCAPED_CHAR', '((\\\\)|(\\;)|(\\,)|(\\[Nn]))');

define ('TSAFE_CHAR', chr(0x20) . '-' . chr(0x21) .  chr(0x23) . '-' . chr(0x2B) . chr(0x2D) . '-' . chr(0x39) . chr(0x3C) . '-' . chr(0x5B) . chr(0x5D) . '-' . chr(0x7E) . NON_US_ASCII);

define ('TEXT', '([' . TSAFE_CHAR . ':' . DQUOTE . ESCAPED_CHAR . ']*);');

use Battis\Calendar\iCalendar\RFC5545\Value;

class Text extends Value {

	protected $name = 'TEXT';

	protected function isValidValue($value) {
		/* FIXME this isn't right */
		return true;
	}
}
