<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Contact;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\End;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Duration;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\DateTimeStamp;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Organizer;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\UniqueIdentifier;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\URL;

use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Attendee;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\FreeBusyTime;
use Battis\Calendar\iCalendar\RFC5545\Properties\Nonstandard\RequestStatus;

/**
 * Free/Busy Component
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
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.6.4 RFC 5545 &sect;3.6.4}
 * ```RFC
 *    Purpose:  Provide a grouping of component properties that describe
 *       either a request for free/busy time, describe a response to a
 *       request for free/busy time, or describe a published set of busy
 *       time.
 * ```
 * ```RFC
 *    Description:  A "VFREEBUSY" calendar component is a grouping of
 *       component properties that represents either a request for free or
 *       busy time information, a reply to a request for free or busy time
 *       information, or a published set of busy time information.
 *
 *       When used to request free/busy time information, the "ATTENDEE"
 *       property specifies the calendar users whose free/busy time is
 *       being requested; the "ORGANIZER" property specifies the calendar
 *       user who is requesting the free/busy time; the "DTSTART" and
 *       "DTEND" properties specify the window of time for which the free/
 *       busy time is being requested; the "UID" and "DTSTAMP" properties
 *       are specified to assist in proper sequencing of multiple free/busy
 *       time requests.
 *
 *       When used to reply to a request for free/busy time, the "ATTENDEE"
 *       property specifies the calendar user responding to the free/busy
 *       time request; the "ORGANIZER" property specifies the calendar user
 *       that originally requested the free/busy time; the "FREEBUSY"
 *       property specifies the free/busy time information (if it exists);
 *       and the "UID" and "DTSTAMP" properties are specified to assist in
 *       proper sequencing of multiple free/busy time replies.
 *
 *       When used to publish busy time, the "ORGANIZER" property specifies
 *       the calendar user associated with the published busy time; the
 *       "DTSTART" and "DTEND" properties specify an inclusive time window
 *       that surrounds the busy time information; the "FREEBUSY" property
 *       specifies the published busy time information; and the "DTSTAMP"
 *       property specifies the DATE-TIME that iCalendar object was
 *       created.
 *
 *       The "VFREEBUSY" calendar component cannot be nested within another
 *       calendar component.  Multiple "VFREEBUSY" calendar components can
 *       be specified within an iCalendar object.  This permits the
 *       grouping of free/busy information into logical collections, such
 *       as monthly groups of busy time information.
 *
 *       The "VFREEBUSY" calendar component is intended for use in
 *       iCalendar object methods involving requests for free time,
 *       requests for busy time, requests for both free and busy, and the
 *       associated replies.
 *
 *       Free/Busy information is represented with the "FREEBUSY" property.
 *       This property provides a terse representation of time periods.
 *       One or more "FREEBUSY" properties can be specified in the
 *       "VFREEBUSY" calendar component.
 *
 *       When present in a "VFREEBUSY" calendar component, the "DTSTART"
 *       and "DTEND" properties SHOULD be specified prior to any "FREEBUSY"
 *       properties.
 *
 *       The recurrence properties ("RRULE", "RDATE", "EXDATE") are not
 *       permitted within a "VFREEBUSY" calendar component.  Any recurring
 *       events are resolved into their individual busy time periods using
 *       the "FREEBUSY" property.
 * ```
 */
class FreeBusy extends Component
{
    protected static $validPropertyTypes = [
        Contact::class => Property::OPTIONAL_SINGLETON,
        Start::class => Property::OPTIONAL_SINGLETON,
        End::class => Property::OPTIONAL_SINGLETON,
        Duration::class => Property::OPTONAL_SINGLETON,
        DateTimeStamp::class => Property::OPTIONAL_SINGLETON,
        Organizer::class => Property::OPTIONAL_SINGLETON,
        UniqueIdentifier::class => Property::OPTIONAL_SINGLETON,
        URL::class => Property::OPTIONAL_SINGLETON,

        Attendee::class => Property::OPTIONAL_MULTIPLE,
        Comment::class => Property::OPTIONAL_MULTIPLE,
        FreeBusyTime::class => Property::OPTIONAL_MULTIPLE,
        RequestStatus::class => Property::OPTIONAL_MULTIPLE
    ];
}
