<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Miscellaneous;

use Battis\Calendar\iCalendar\RFC5545\Value;
use Battis\Calendar\iCalendar\Exceptions\PropertyException;

/**
Nonstandard Property Property

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
```RFC
The following properties can appear within calendar components, as
specified by each component property definition.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.8 RFC 5545 &sect;3.8.8}
```RFC
The following properties specify information about a number of
miscellaneous features of calendar components.
```

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.8.2 RFC 5545 &sect;3.8.8.2}
```RFC
Purpose:  This class of property provides a framework for defining
	 non-standard properties.
```
```RFC
Description:  The MIME Calendaring and Scheduling Content Type
	 provides a "standard mechanism for doing non-standard things".
	 This extension support is provided for implementers to "push the
	 envelope" on the existing version of the memo.  Extension
	 properties are specified by property and/or property parameter
	 names that have the prefix text of "X-" (the two-character
	 sequence: LATIN CAPITAL LETTER X character followed by the HYPHEN-
	 MINUS character).  It is recommended that vendors concatenate onto
	 this sentinel another short prefix text to identify the vendor.
	 This will facilitate readability of the extensions and minimize
	 possible collision of names between different vendors.  User
	 agents that support this content type are expected to be able to
	 parse the extension properties and property parameters but can
	 ignore them.

	 At present, there is no registration authority for names of
	 extension properties and property parameters.  The value type for
	 this property is TEXT.  Optionally, the value type can be any of
	 the other valid value types.
```
*/
class NonstandardProperty extends IANAProperty {

	public function __construct(...$param) {
		if (is_string($param[0]) && preg_match('/^' . X_NAME . '$/', $param[0])) {
			parent::__construct(...$param);
		} else {
			throw new PropertyException('X-property must be named starting \'X-\'');
		}
	}
}
