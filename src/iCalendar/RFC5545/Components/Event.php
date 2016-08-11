<?php

namespace Battis\Calendar\iCalendar\RFC5545\Components;

use Battis\Calendar\iCalendar\RFC5545\Component;
use Battis\Calendar\iCalendar\RFC5545\Property;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Classification;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\Created;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Description;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Start;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\GeographicPosition;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\LastModified;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Location;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Organizer;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Priority;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\DateTimeStamp;
use Battis\Calendar\iCalendar\RFC5545\Properties\ChangeManagement\SequenceNumber;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Status;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Summary;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\TimeTransparency;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\UniqueIdentifier;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\URL;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\RecurrenceID;

use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\End;
use Battis\Calendar\iCalendar\RFC5545\Properties\DateTime\Duration;

use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Attachment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Attendee;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Categories;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Comment;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\Contact;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\ExceptionDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\ExceptionRule;
use Battis\Calendar\iCalendar\RFC5545\Properties\Miscellaneous\RequestStatus;
use Battis\Calendar\iCalendar\RFC5545\Properties\Relationship\RelatedTo;
use Battis\Calendar\iCalendar\RFC5545\Properties\Descriptive\Resources;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\iCalendar\RFC5545\Properties\Recurrence\RecurrenceRule;

/**
 * Event Component
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
 * {@link https://tools.ietf.org/rfcmarkup/5545#section-3.6.1 RFC 5545 &sect;3.6.1}
 * ```RFC
 *    Purpose:  Provide a grouping of component properties that describe an
 *       event.
 * ```
 * ```RFC
 *    Description:  A "VEVENT" calendar component is a grouping of
 *       component properties, possibly including "VALARM" calendar
 *       components, that represents a scheduled amount of time on a
 *       calendar.  For example, it can be an activity; such as a one-hour
 *       long, department meeting from 8:00 AM to 9:00 AM, tomorrow.
 *       Generally, an event will take up time on an individual calendar.
 *       Hence, the event will appear as an opaque interval in a search for
 *       busy time.  Alternately, the event can have its Time Transparency
 *       set to "TRANSPARENT" in order to prevent blocking of the event in
 *       searches for busy time.
 *
 *       The "VEVENT" is also the calendar component used to specify an
 *       anniversary or daily reminder within a calendar.  These events
 *       have a DATE value type for the "DTSTART" property instead of the
 *       default value type of DATE-TIME.  If such a "VEVENT" has a "DTEND"
 *       property, it MUST be specified as a DATE value also.  The
 *       anniversary type of "VEVENT" can span more than one date (i.e.,
 *       "DTEND" property value is set to a calendar date after the
 *       "DTSTART" property value).  If such a "VEVENT" has a "DURATION"
 *       property, it MUST be specified as a "dur-day" or "dur-week" value.
 *
 *       The "DTSTART" property for a "VEVENT" specifies the inclusive
 *       start of the event.  For recurring events, it also specifies the
 *       very first instance in the recurrence set.  The "DTEND" property
 *       for a "VEVENT" calendar component specifies the non-inclusive end
 *       of the event.  For cases where a "VEVENT" calendar component
 *       specifies a "DTSTART" property with a DATE value type but no
 *       "DTEND" nor "DURATION" property, the event's duration is taken to
 *       be one day.  For cases where a "VEVENT" calendar component
 *       specifies a "DTSTART" property with a DATE-TIME value type but no
 *       "DTEND" property, the event ends on the same calendar date and
 *       time of day specified by the "DTSTART" property.
 *
 *       The "VEVENT" calendar component cannot be nested within another
 *       calendar component.  However, "VEVENT" calendar components can be
 *       related to each other or to a "VTODO" or to a "VJOURNAL" calendar
 *       component with the "RELATED-TO" property.
 * ```
 */
class Event extends Component
{
    /** @inheritDoc */
    // TODO double-check
    protected static $validPropertyTypes = [
        Classification::class => Property::OPTIONAL_SINGLETON,
        Created::class => Property::OPTIONAL_SINGLETON,
        Description::class => Property::OPTIONAL_SINGLETON,
        Start::class => Property::OPTIONAL_SINGLETON,
        GeographicPosition::class => Property::OPTIONAL_SINGLETON,
        LastModified::class => Property::OPTIONAL_SINGLETON,
        Location::class => Property::OPTIONAL_SINGLETON,
        Organizer::class => Property::OPTIONAL_SINGLETON,
        Priority::class => Property::OPTIONAL_SINGLETON,
        DateTimeStamp::class => Property::OPTIONAL_SINGLETON,
        SequenceNumber::class => Property::OPTIONAL_SINGLETON,
        Status::class => Property::OPTIONAL_SINGLETON,
        Summary::class => Property::OPTIONAL_SINGLETON,
        TimeTransparency::class => Property::OPTIONAL_SINGLETON,
        UniqueIdentifier::class => Property::OPTIONAL_SINGLETON,
        URL::class => Property::OPTIONAL_SINGLETON,
        RecurrenceID::class => Property::OPTIONAL_SINGLETON,

        End::class => Property::OPTIONAL_SINGLETON,
        Duration::class => Property::OPTIONAL_SINGLETON,

        Attachment::class => Property::OPTIONAL_MULTIPLE,
        Attendee::class => Property::OPTIONAL_MULTIPLE,
        Categories::class => Property::OPTIONAL_MULTIPLE,
        Comment::class => Property::OPTIONAL_MULTIPLE,
        Contact::class => Property::OPTIONAL_MULTIPLE,
        ExceptionDateTimes::class => Property::OPTIONAL_MULTIPLE,
        ExceptionRule::class => Property::OPTIONAL_MULTIPLE,
        RequestStatus::class => Property::OPTIONAL_MULTIPLE,
        RelatedTo::class => Property::OPTIONAL_MULTIPLE,
        Resources::class => Property::OPTIONAL_MULTIPLE,
        RecurrenceDateTimes::class => Property::OPTIONAL_MULTIPLE,
        RecurrenceRule::class => Property::OPTIONAL_MULTIPLE
    ];

    protected static $validComponentTypes = [
        Alarm::class
    ];

    public function isValid(Component &$containingComponent = null)
    {
        if (!parent::isValid($containingComponent)) {
            return false;
        }

        return (count($this->get(End::class)) + count($this->get(Duration::class))) > 1;
    }
}
