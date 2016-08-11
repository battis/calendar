<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Alarm;

use Battis\Calendar\iCalendar\RFC5545\Properties\IntegerProperty;

/**
 * Repeat Count Property
 *
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.8 RFC 5545 &sect;3.8}
 * ```RFC
 * The following properties can appear within calendar components, as
 * specified by each component property definition.
 * ```
 *
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.6 RFC 5545 &sect;3.8.6}
 * ```RFC
 * The following properties specify alarm information in calendar
 * components.
 * ```
 *
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.6.2 RFC 5545 &sect;3.8.6.2}
 * ```RFC
 * Purpose:  This property defines the number of times the alarm should
 * 	 be repeated, after the initial trigger.
 * ```
 * ```RFC
 * Description:  This property defines the number of times an alarm
 * 	 should be repeated after its initial trigger.  If the alarm
 * 	 triggers more than once, then this property MUST be specified
 * 	 along with the "DURATION" property.
 * 	 ```
 */
class RepeatCount extends IntegerProperty {

	protected $name = 'REPEAT';
}
