<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Miscellaneous;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
Request Status Property

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

{@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.8.3 RFC 5545 &sect;3.8.8.3}
```RFC
Purpose:  This property defines the status code returned for a
	 scheduling request.
```
```RFC
Description:  This property is used to return status code information
	 related to the processing of an associated iCalendar object.  The
	 value type for this property is TEXT.

	 The value consists of a short return status component, a longer
	 return status description component, and optionally a status-
	 specific data component.  The components of the value are
	 separated by the SEMICOLON character.

	 The short return status is a PERIOD character separated pair or
	 3-tuple of integers.  For example, "3.1" or "3.1.1".  The
	 successive levels of integers provide for a successive level of
	 status code granularity.

	 The following are initial classes for the return status code.
	 Individual iCalendar object methods will define specific return
	 status codes for these classes.  In addition, other classes for
	 the return status code may be defined using the registration
	 process defined later in this memo.

+--------+----------------------------------------------------------+
| Short  | Longer Return Status Description                         |
| Return |                                                          |
| Status |                                                          |
| Code   |                                                          |
+--------+----------------------------------------------------------+
| 1.xx   | Preliminary success.  This class of status code          |
|        | indicates that the request has been initially processed  |
|        | but that completion is pending.                          |
|        |                                                          |
| 2.xx   | Successful.  This class of status code indicates that    |
|        | the request was completed successfully.  However, the    |
|        | exact status code can indicate that a fallback has been  |
|        | taken.                                                   |
|        |                                                          |
| 3.xx   | Client Error.  This class of status code indicates that  |
|        | the request was not successful.  The error is the result |
|        | of either a syntax or a semantic error in the client-    |
|        | formatted request.  Request should not be retried until  |
|        | the condition in the request is corrected.               |
|        |                                                          |
| 4.xx   | Scheduling Error.  This class of status code indicates   |
|        | that the request was not successful.  Some sort of error |
|        | occurred within the calendaring and scheduling service,  |
|        | not directly related to the request itself.              |
+--------+----------------------------------------------------------+
```
*/
class RequestStatus extends TextProperty {

	protected $name = 'REQUEST-STATUS';
}
