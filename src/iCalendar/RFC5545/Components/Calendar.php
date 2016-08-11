<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\Calendar\ProductIdentifier;
use Battis\Calendar\iCalendar\RFC5545\Properties\Calendar\Version;
use Battis\Calendar\iCalendar\RFC5545\Properties\Calendar\Scale;
use Battis\Calendar\iCalendar\RFC5545\Properties\Calendar\Method;

use Battis\Calendar\Exceptions\CalendarException;

/**
 * Calendar Component
 *
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.6 RFC 5545 &sect;3.6}
 * ```RFC
 *    The body of the iCalendar object consists of a sequence of calendar
 *    properties and one or more calendar components.  The calendar
 *    properties are attributes that apply to the calendar object as a
 *    whole.  The calendar components are collections of properties that
 *    express a particular calendar semantic.  For example, the calendar
 *    component can specify an event, a to-do, a journal entry, time zone
 *    information, free/busy time information, or an alarm.
 * ```
 * ```RFC
 *    An iCalendar object MUST include the "PRODID" and "VERSION" calendar
 *    properties.  In addition, it MUST include at least one calendar
 *    component.  Special forms of iCalendar objects are possible to
 *    publish just busy time (i.e., only a "VFREEBUSY" calendar component)
 *    or time zone (i.e., only a "VTIMEZONE" calendar component)
 *    information.  In addition, a complex iCalendar object that is used to
 *    capture a complete snapshot of the contents of a calendar is possible
 *    (e.g., composite of many different calendar components).  More
 *    commonly, an iCalendar object will consist of just a single "VEVENT",
 *    "VTODO", or "VJOURNAL" calendar component.  Applications MUST ignore
 *    x-comp and iana-comp values they don't recognize.  Applications that
 *    support importing iCalendar objects SHOULD support all of the
 *    component types defined in this document, and SHOULD NOT silently
 *    drop any components as that can lead to user data loss.
 * ```
 */
class Calendar extends Component
{

    /** @inheritdoc */
    protected static $validPropertyTypes = [
        ProductIdentifier::class => Property::REQUIRED_SINGLETON,
        Version::class => Property::REQUIRED_SINGLETON,

        Scale::class => Property::OPTIONAL_SINGLETON,
        Method::class => Property::OPTIONAL_SINGLETON
    ];

    /** @inheritdoc */
    protected static $validComponentTypes = [
        Event::class,
        ToDo::class,
        Journal::class,
        FreeBusy::class,
        TimeZone::class
    ];

    protected static function parseStream(&$stream)
    {
        do {
            $contentLine = static::nextContentLine($stream);
        } while ($contentLine && $contentLine != 'BEGIN:VCALENDAR');
        return parent::parseStream($stream);
    }

    /** @inheritdoc */
    public function isValid(\Battis\Calendar\iCalendar\RFC5545\Component &$containingComponent = null)
    {
        if (!parent::isValid($containingComponent)) {
            return false;
        }

        return count($this->components) > 0;
    }
}
