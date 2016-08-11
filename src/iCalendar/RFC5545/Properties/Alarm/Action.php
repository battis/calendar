<?php

namespace Battis\Calendar\iCalendar\RFC5545\Properties\Alarm;

use Battis\Calendar\iCalendar\RFC5545\Properties\TextProperty;

/**
 * Action Property
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
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.8.6.1 RFC 5545 &sect;3.8.6.1}
 * ```RFC
 * Purpose:  This property defines the action to be invoked when an
 * 	 alarm is triggered.
 * ```
 * ```RFC
 * Description:  Each "VALARM" calendar component has a particular type
 * 	 of action with which it is associated.  This property specifies
 * 	 the type of action.  Applications MUST ignore alarms with x-name
 * 	 and iana-token values they don't recognize.
 * ```
 */
class Action extends TextProperty {

	/**
	 * @inheritDoc
	 * @var string
	 */
	protected $name = 'ACTION';
}
