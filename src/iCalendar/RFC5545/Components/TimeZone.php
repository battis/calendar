<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone\Identifier;
use Battis\Calendar\iCalendar\RFC5545\Properties\TimeZone\URL;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\LastModified;

/**
 * Time Zone Component
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
 *
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.6.5 RFC 5545 &sect;3.6.5}
 * ```RFC
 *    Purpose:  Provide a grouping of component properties that defines a
 *       time zone.
 * ```
 * ```RFC
 *    Description:  A time zone is unambiguously defined by the set of time
 *       measurement rules determined by the governing body for a given
 *       geographic area.  These rules describe, at a minimum, the base
 *       offset from UTC for the time zone, often referred to as the
 *       Standard Time offset.  Many locations adjust their Standard Time
 *       forward or backward by one hour, in order to accommodate seasonal
 *       changes in number of daylight hours, often referred to as Daylight
 *       Saving Time.  Some locations adjust their time by a fraction of an
 *       hour.  Standard Time is also known as Winter Time.  Daylight
 *       Saving Time is also known as Advanced Time, Summer Time, or Legal
 *       Time in certain countries.  The following table shows the changes
 *       in time zone rules in effect for New York City starting from 1967.
 *       Each line represents a description or rule for a particular
 *       observance.
 *
 *                          Effective Observance Rule
 *
 *      +-----------+--------------------------+--------+--------------+
 *      | Date      | (Date-Time)              | Offset | Abbreviation |
 *      +-----------+--------------------------+--------+--------------+
 *      | 1967-1973 | last Sun in Apr, 02:00   | -0400  | EDT          |
 *      |           |                          |        |              |
 *      | 1967-2006 | last Sun in Oct, 02:00   | -0500  | EST          |
 *      |           |                          |        |              |
 *      | 1974-1974 | Jan 6, 02:00             | -0400  | EDT          |
 *      |           |                          |        |              |
 *      | 1975-1975 | Feb 23, 02:00            | -0400  | EDT          |
 *      |           |                          |        |              |
 *      | 1976-1986 | last Sun in Apr, 02:00   | -0400  | EDT          |
 *      |           |                          |        |              |
 *      | 1987-2006 | first Sun in Apr, 02:00  | -0400  | EDT          |
 *      |           |                          |        |              |
 *      | 2007-*    | second Sun in Mar, 02:00 | -0400  | EDT          |
 *      |           |                          |        |              |
 *      | 2007-*    | first Sun in Nov, 02:00  | -0500  | EST          |
 *      +-----------+--------------------------+--------+--------------+
 *
 *    Note: The specification of a global time zone registry is not
 *          addressed by this document and is left for future study.
 *          However, implementers may find the TZ database [TZDB] a useful
 *          reference.  It is an informal, public-domain collection of time
 *          zone information, which is currently being maintained by
 *          volunteer Internet participants, and is used in several
 *          operating systems.  This database contains current and
 *          historical time zone information for a wide variety of
 *          locations around the globe; it provides a time zone identifier
 *          for every unique time zone rule set in actual use since 1970,
 *          with historical data going back to the introduction of standard
 *          time.
 *
 *       Interoperability between two calendaring and scheduling
 *       applications, especially for recurring events, to-dos or journal
 *       entries, is dependent on the ability to capture and convey date
 *       and time information in an unambiguous format.  The specification
 *       of current time zone information is integral to this behavior.
 *
 *       If present, the "VTIMEZONE" calendar component defines the set of
 *       Standard Time and Daylight Saving Time observances (or rules) for
 *       a particular time zone for a given interval of time.  The
 *       "VTIMEZONE" calendar component cannot be nested within other
 *       calendar components.  Multiple "VTIMEZONE" calendar components can
 *       exist in an iCalendar object.  In this situation, each "VTIMEZONE"
 *       MUST represent a unique time zone definition.  This is necessary
 *       for some classes of events, such as airline flights, that start in
 *       one time zone and end in another.
 *
 *       The "VTIMEZONE" calendar component MUST include the "TZID"
 *       property and at least one definition of a "STANDARD" or "DAYLIGHT"
 *       sub-component.  The "STANDARD" or "DAYLIGHT" sub-component MUST
 *       include the "DTSTART", "TZOFFSETFROM", and "TZOFFSETTO"
 *       properties.
 *
 *       An individual "VTIMEZONE" calendar component MUST be specified for
 *       each unique "TZID" parameter value specified in the iCalendar
 *       object.  In addition, a "VTIMEZONE" calendar component, referred
 *       to by a recurring calendar component, MUST provide valid time zone
 *       information for all recurrence instances.
 *
 *       Each "VTIMEZONE" calendar component consists of a collection of
 *       one or more sub-components that describe the rule for a particular
 *       observance (either a Standard Time or a Daylight Saving Time
 *       observance).  The "STANDARD" sub-component consists of a
 *       collection of properties that describe Standard Time.  The
 *       "DAYLIGHT" sub-component consists of a collection of properties
 *       that describe Daylight Saving Time.  In general, this collection
 *       of properties consists of:
 *
 *       *  the first onset DATE-TIME for the observance;
 *
 *       *  the last onset DATE-TIME for the observance, if a last onset is
 *          known;
 *
 *       *  the offset to be applied for the observance;
 *
 *       *  a rule that describes the day and time when the observance
 *          takes effect;
 *
 *       *  an optional name for the observance.
 *
 *       For a given time zone, there may be multiple unique definitions of
 *       the observances over a period of time.  Each observance is
 *       described using either a "STANDARD" or "DAYLIGHT" sub-component.
 *       The collection of these sub-components is used to describe the
 *       time zone for a given period of time.  The offset to apply at any
 *       given time is found by locating the observance that has the last
 *       onset date and time before the time in question, and using the
 *       offset value from that observance.
 *
 *       The top-level properties in a "VTIMEZONE" calendar component are:
 *
 *       The mandatory "TZID" property is a text value that uniquely
 *       identifies the "VTIMEZONE" calendar component within the scope of
 *       an iCalendar object.
 *
 *       The optional "LAST-MODIFIED" property is a UTC value that
 *       specifies the date and time that this time zone definition was
 *       last updated.
 *
 *       The optional "TZURL" property is a url value that points to a
 *       published "VTIMEZONE" definition.  "TZURL" SHOULD refer to a
 *       resource that is accessible by anyone who might need to interpret
 *       the object.  This SHOULD NOT normally be a "file" URL or other URL
 *       that is not widely accessible.
 *
 *       The collection of properties that are used to define the
 *       "STANDARD" and "DAYLIGHT" sub-components include:
 *
 *       The mandatory "DTSTART" property gives the effective onset date
 *       and local time for the time zone sub-component definition.
 *       "DTSTART" in this usage MUST be specified as a date with a local
 *       time value.
 *
 *       The mandatory "TZOFFSETFROM" property gives the UTC offset that is
 *       in use when the onset of this time zone observance begins.
 *       "TZOFFSETFROM" is combined with "DTSTART" to define the effective
 *       onset for the time zone sub-component definition.  For example,
 *       the following represents the time at which the observance of
 *       Standard Time took effect in Fall 1967 for New York City:
 *
 *        DTSTART:19671029T020000
 *
 *        TZOFFSETFROM:-0400
 *
 *       The mandatory "TZOFFSETTO" property gives the UTC offset for the
 *       time zone sub-component (Standard Time or Daylight Saving Time)
 *       when this observance is in use.
 *
 *       The optional "TZNAME" property is the customary name for the time
 *       zone.  This could be used for displaying dates.
 *
 *       The onset DATE-TIME values for the observance defined by the time
 *       zone sub-component is defined by the "DTSTART", "RRULE", and
 *       "RDATE" properties.
 *
 *       The "RRULE" property defines the recurrence rule for the onset of
 *       the observance defined by this time zone sub-component.  Some
 *       specific requirements for the usage of "RRULE" for this purpose
 *       include:
 *
 *       *  If observance is known to have an effective end date, the
 *          "UNTIL" recurrence rule parameter MUST be used to specify the
 *          last valid onset of this observance (i.e., the UNTIL DATE-TIME
 *          will be equal to the last instance generated by the recurrence
 *          pattern).  It MUST be specified in UTC time.
 *
 *       *  The "DTSTART" and the "TZOFFSETFROM" properties MUST be used
 *          when generating the onset DATE-TIME values (instances) from the
 *          "RRULE".
 *
 *       The "RDATE" property can also be used to define the onset of the
 *       observance by giving the individual onset date and times.  "RDATE"
 *       in this usage MUST be specified as a date with local time value,
 *       relative to the UTC offset specified in the "TZOFFSETFROM"
 *       property.
 *
 *       The optional "COMMENT" property is also allowed for descriptive
 *       explanatory text.
 * ```
 */
class TimeZone extends Component
{
    protected static $validPropertyTypes = [
        Identifier::class => Property::REQUIRED_SINGLETON,

        LastModified::class => Property::OPTIONAL_SINGLETON,
        URL::class => Property::OPTIONAL_SINGLETON
    ];

    protected static $validComponentTypes = [
        Standard::class,
        Daylight::class
    ];

    public function isValid(Component &$containingComponent = null)
    {
        if (parent::isValid()) {
            return false;
        }

        /* MUST have at least one standard or daylight subcomponent defined */
        return count($this->components) > 0;
    }
}
