<?php
	
namespace Battis\Calendar\iCalendar\RFC2445\Properties\Nonstandard;

require_once __DIR__ . '/../../grammar.php';

use Battis\Calendar\iCalendar\RFC2445\Value;
use Battis\Calendar\iCalendar\Exceptions\PropertyException;

class XProperty extends IANAProperty {
	
	public function __construct(...$param) {
		if (is_string($param[0]) && preg_match('/^' . X_NAME . '$/', $param[0])) {
			parent::__construct(...$param);
		} else {
			throw new PropertyException('X-property must be named starting \'X-\'');
		}
	}
}