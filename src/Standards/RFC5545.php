<?php

namespace Battis\Calendar\Standards;


use Battis\Calendar\Calendar;
use Battis\Calendar\Components\Alarm;
use Battis\Calendar\Components\Event;
use Battis\Calendar\Components\FreeBusy;
use Battis\Calendar\Components\Journal;
use Battis\Calendar\Components\TimeZone;
use Battis\Calendar\Components\TimeZone\DaylightSavingTime;
use Battis\Calendar\Components\TimeZone\StandardTime;
use Battis\Calendar\Components\ToDo;
use Battis\Calendar\Parameters\AlarmTriggerRelationship;
use Battis\Calendar\Parameters\AlternateTextRepresentation;
use Battis\Calendar\Parameters\CalendarUserType;
use Battis\Calendar\Parameters\CommonName;
use Battis\Calendar\Parameters\Delegatees;
use Battis\Calendar\Parameters\Delegators;
use Battis\Calendar\Parameters\DirectoryEntryReference;
use Battis\Calendar\Parameters\FormatType;
use Battis\Calendar\Parameters\FreeBusyTimeType;
use Battis\Calendar\Parameters\GroupOrListMembership;
use Battis\Calendar\Parameters\InlineEncoding;
use Battis\Calendar\Parameters\Language;
use Battis\Calendar\Parameters\ParticipationRole;
use Battis\Calendar\Parameters\ParticipationStatus;
use Battis\Calendar\Parameters\RecurrenceIdentifierRange;
use Battis\Calendar\Parameters\RelationshipType;
use Battis\Calendar\Parameters\RSVPExpectation;
use Battis\Calendar\Parameters\SentBy;
use Battis\Calendar\Parameters\TimeZoneIdentifier as TimeZoneIdentifierParameter;
use Battis\Calendar\Parameters\ValueDataTypes;
use Battis\Calendar\Properties\Calendar\CalendarScale;
use Battis\Calendar\Properties\Calendar\Method;
use Battis\Calendar\Properties\Calendar\ProductIdentifier;
use Battis\Calendar\Properties\Calendar\Version;
use Battis\Calendar\Properties\Component\Alarm\Action;
use Battis\Calendar\Properties\Component\Alarm\RepeatCount;
use Battis\Calendar\Properties\Component\Alarm\Trigger;
use Battis\Calendar\Properties\Component\ChangeManagement\DateTimeCreated;
use Battis\Calendar\Properties\Component\ChangeManagement\DateTimeStamp;
use Battis\Calendar\Properties\Component\ChangeManagement\LastModified;
use Battis\Calendar\Properties\Component\ChangeManagement\SequenceNumber;
use Battis\Calendar\Properties\Component\DateTime\DateTimeCompleted;
use Battis\Calendar\Properties\Component\DateTime\DateTimeDue;
use Battis\Calendar\Properties\Component\DateTime\DateTimeEnd;
use Battis\Calendar\Properties\Component\DateTime\DateTimeStart;
use Battis\Calendar\Properties\Component\DateTime\Duration;
use Battis\Calendar\Properties\Component\DateTime\FreeBusyTime;
use Battis\Calendar\Properties\Component\DateTime\TimeTransparency;
use Battis\Calendar\Properties\Component\Descriptive\Attachment;
use Battis\Calendar\Properties\Component\Descriptive\Categories;
use Battis\Calendar\Properties\Component\Descriptive\Classification;
use Battis\Calendar\Properties\Component\Descriptive\Comment;
use Battis\Calendar\Properties\Component\Descriptive\Description;
use Battis\Calendar\Properties\Component\Descriptive\GeographicPosition;
use Battis\Calendar\Properties\Component\Descriptive\Location;
use Battis\Calendar\Properties\Component\Descriptive\PercentComplete;
use Battis\Calendar\Properties\Component\Descriptive\Priority;
use Battis\Calendar\Properties\Component\Descriptive\Resources;
use Battis\Calendar\Properties\Component\Descriptive\Status;
use Battis\Calendar\Properties\Component\Descriptive\Summary;
use Battis\Calendar\Properties\Component\Miscellaneous\RequestStatus;
use Battis\Calendar\Properties\Component\Recurrence\ExceptionDateTimes;
use Battis\Calendar\Properties\Component\Recurrence\RecurrenceDateTimes;
use Battis\Calendar\Properties\Component\Recurrence\RecurrenceRule;
use Battis\Calendar\Properties\Component\Relationship\Attendee;
use Battis\Calendar\Properties\Component\Relationship\Contact;
use Battis\Calendar\Properties\Component\Relationship\Organizer;
use Battis\Calendar\Properties\Component\Relationship\RecurrenceID;
use Battis\Calendar\Properties\Component\Relationship\RelatedTo;
use Battis\Calendar\Properties\Component\Relationship\UniqueIdentifier;
use Battis\Calendar\Properties\Component\Relationship\URL;
use Battis\Calendar\Properties\Component\TimeZone\TimeZoneIdentifier;
use Battis\Calendar\Properties\Component\TimeZone\TimeZoneName;
use Battis\Calendar\Properties\Component\TimeZone\TimeZoneOffsetFrom;
use Battis\Calendar\Properties\Component\TimeZone\TimeZoneOffsetTo;
use Battis\Calendar\Properties\Component\TimeZone\TimeZoneURL;
use Battis\Calendar\Values\Binary;
use Battis\Calendar\Values\Boolean;
use Battis\Calendar\Values\CalendarUserAddress;
use Battis\Calendar\Values\Date;
use Battis\Calendar\Values\DateTime;
use Battis\Calendar\Values\Duration as DurationValue;
use Battis\Calendar\Values\FloatValue;
use Battis\Calendar\Values\Integer;
use Battis\Calendar\Values\PeriodOfTime;
use Battis\Calendar\Values\RecurrenceRule as RecurrenceRuleValue;
use Battis\Calendar\Values\Text;
use Battis\Calendar\Values\Time;
use Battis\Calendar\Values\URI;
use Battis\Calendar\Values\UTCOffset;

interface RFC5545
{
    const
        CONTENTLINE_WIDTH = 75;

    /** @link https://tools.ietf.org/html/rfc5545#section-2.1 &sect;2.1. Formatting Conventions */
    const
        WSP = "[ \t]",
        CRLF = "\r\n",
        DQUOTE = '"';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.1 &sect;3.1. Content Lines */
    const
        CONTROL = '[\\x00-\\x08\\x0A-\\x1F\\x7F]',
        NON_US_ASCII = '(?:' . RFC3629::UTF8_2 . '|' . RFC3629::UTF8_3 . '|' . RFC3629::UTF8_4 . ')',
        VALUE_CHAR = '(?:' . self::WSP . '|[\\x21-\\x7E]|' . self::NON_US_ASCII . ')',
        SAFE_CHAR = '(?:' . self::WSP . '|[\\x21\\x23-\\x2B\\x2D-\\x39\\x3C-\\x7E]|' . self::NON_US_ASCII . ')',
        QSAFE_CHAR = '(?:' . self::WSP . '|[\\x21\\x23-\\x7E]|' . self::NON_US_ASCII . ')',
        QUOTED_STRING = self::DQUOTE . self::QSAFE_CHAR . '*' . self::DQUOTE,
        VALUE = self::VALUE_CHAR . '*',
        VENDORID = '(?:' . ABNF::ALPHA . '|\\d){3,}',
        IANA_TOKEN = '(?:' . ABNF::ALPHA . '|\\d|-' . ')+',
        X_NAME = 'X-' . self::VENDORID . '?(?:' . ABNF::ALPHA . '|\\d|-)+',
        PARAMTEXT = self::SAFE_CHAR . '*',
        PARAM_VALUE = '(?:' . self::PARAMTEXT . '|' . self::QUOTED_STRING . ')',
        PARAM_NAME = '(?:' . self::IANA_TOKEN . '|' . self::X_NAME . ')',
        PARAMETER_KEYVALUE_SEPARATOR = '=',
        PARAM = self::PARAM_NAME . self::PARAMETER_KEYVALUE_SEPARATOR . self::PARAM_VALUE . '(?:,' . self::PARAM_VALUE . ')*',
        NAME = '(?:' . self::IANA_TOKEN . '|' . self::X_NAME . ')',
        PARAMETER_SEPARATOR = ';',
        VALUE_SEPARATOR = ':',
        CONTENTLINE = self::NAME . '(?:' . self::PARAMETER_SEPARATOR . self::PARAM . ')' . self::VALUE_SEPARATOR . self::VALUE . self::CRLF;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.1.1 &sect;3.1.1. List and Field Separators */
    const
        LIST_SEPARATOR = ',',
        FIELD_SEPARATOR = ';';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.2 &sect;3.2. Property Parameters */
    const
        ALTERNATE_TEXT_REPRESENTATION = 'ALTREP',
        COMMON_NAME = 'CN',
        CALENDAR_USER_TYPE = 'CUTYPE',
        DELEGATORS = 'DELEGATED-FROM',
        DELEGATEES = 'DELEGATED-TO',
        DIRECTORY_ENTRY_REFERENCE = 'DIR',
        IN_LINE_ENCODING = 'ENCODING',
        FORMAT_TYPE = 'FMTTYPE',
        FREE_BUSY_TIME_TYPE = 'FBTYPE',
        LANGUAGE = 'LANGUAGE',
        GROUP_OR_LIST_MEMBERSHIP = 'MEMBER',
        PARTICIPATION_STATUS = 'PARTSTAT',
        RECURRENCE_IDENTIFIER_RANGE = 'RANGE',
        ALARM_TRIGGER_RELATIONSHIP = 'RELATED',
        RELATIONSHIP_TYPE = 'RELTYPE',
        PARTICIPATION_ROLE = 'ROLE',
        RSVP_EXPECTATION = 'RSVP',
        SENT_BY = 'SENT-BY',
        TIME_ZONE_IDENTIFIER = 'TZID',
        VALUE_DATA_TYPES = 'VALUE',
        PROPERTY_PARAMETERS = [
        self::ALTERNATE_TEXT_REPRESENTATION => AlternateTextRepresentation::class,
        self::COMMON_NAME => CommonName::class,
        self::CALENDAR_USER_TYPE => CalendarUserType::class,
        self::DELEGATORS => Delegators::class,
        self::DELEGATEES => Delegatees::class,
        self::DIRECTORY_ENTRY_REFERENCE => DirectoryEntryReference::class,
        self::IN_LINE_ENCODING => InlineEncoding::class,
        self::FORMAT_TYPE => FormatType::class,
        self::FREE_BUSY_TIME_TYPE => FreeBusyTimeType::class,
        self::LANGUAGE => Language::class,
        self::GROUP_OR_LIST_MEMBERSHIP => GroupOrListMembership::class,
        self::PARTICIPATION_STATUS => ParticipationStatus::class,
        self::RECURRENCE_IDENTIFIER_RANGE => RecurrenceIdentifierRange::class,
        self::ALARM_TRIGGER_RELATIONSHIP => AlarmTriggerRelationship::class,
        self::RELATIONSHIP_TYPE => RelationshipType::class,
        self::PARTICIPATION_ROLE => ParticipationRole::class,
        self::RSVP_EXPECTATION => RSVPExpectation::class,
        self::SENT_BY => SentBy::class,
        self::TIME_ZONE_IDENTIFIER => TimeZoneIdentifierParameter::class,
        self::VALUE_DATA_TYPES => ValueDataTypes::class
    ];

    /** @link https://tools.ietf.org/html/rfc5545#section-3.2 &sect;3.2. Property Parameters */
    const PROPERTY_PARAMETER_VALUES = [
        self::ALTERNATE_TEXT_REPRESENTATION => URI::class,
        self::COMMON_NAME => Text::class,
        self::CALENDAR_USER_TYPE => Text::class,
        self::DELEGATORS => CalendarUserAddress::class,
        self::DELEGATEES => CalendarUserAddress::class,
        self::DIRECTORY_ENTRY_REFERENCE => URI::class,
        self::IN_LINE_ENCODING => Text::class,
        self::FORMAT_TYPE => Text::class,
        self::FREE_BUSY_TIME_TYPE => Text::class,
        self::LANGUAGE => Text::class,
        self::GROUP_OR_LIST_MEMBERSHIP => CalendarUserAddress::class,
        self::PARTICIPATION_STATUS => Text::class,
        self::RECURRENCE_IDENTIFIER_RANGE => Text::class,
        self::ALARM_TRIGGER_RELATIONSHIP => Text::class,
        self::RELATIONSHIP_TYPE => Text::class,
        self::PARTICIPATION_ROLE => Text::class,
        self::RSVP_EXPECTATION => Boolean::class,
        self::SENT_BY => CalendarUserAddress::class,
        self::TIME_ZONE_IDENTIFIER => Text::class,
        self::VALUE_DATA_TYPES => Text::class
    ];

    const
        CALENDAR = 'VCALENDAR',
        EVENT = 'VEVENT',
        TO_DO = 'VTODO',
        JOURNAL = 'VJOURNAL',
        FREE_BUSY = 'VFREEBUSY',
        TIME_ZONE = 'VTIMEZONE',
        STANDARD_TIME = 'STANDARD',
        DAYLIGHT_SAVING_TIME = 'DAYLIGHT',
        ALARM = 'VALARM',
        COMPONENT_BEGIN = 'BEGIN:',
        COMPONENT_END = 'END:',
        COMPONENTS = [
        self::CALENDAR => Calendar::class,
        self::EVENT => Event::class,
        self::TO_DO => ToDo::class,
        self::JOURNAL => Journal::class,
        self::FREE_BUSY => FreeBusy::class,
        self::TIME_ZONE => TimeZone::class,
        self::STANDARD_TIME => StandardTime::class,
        self::DAYLIGHT_SAVING_TIME => DaylightSavingTime::class,
        self::ALARM => Alarm::class
    ];

    const
        CALENDAR_SCALE = 'CALSCALE',
        METHOD = 'METHOD',
        PRODUCT_IDENTIFIER = 'PRODID',
        VERSION = 'VERSION',
        ATTACHMENT = 'ATTACH',
        CATEGORIES = 'CATEGORIES',
        CLASSIFICATION = 'CLASS',
        COMMENT = 'COMMENT',
        DESCRIPTION = 'DESCRIPTION',
        GEOGRAPHIC_POSITION = 'GEO',
        LOCATION = 'LOCATION',
        PERCENT_COMPLETE = 'PERCENT-COMPLETE',
        PRIORITY = 'PRIORITY',
        RESOURCES = 'RESOURCES',
        STATUS = 'STATUS',
        SUMMARY = 'SUMMARY',
        DATE_TIME_COMPLETED = 'COMPLETED',
        DATE_TIME_END = 'DTEND',
        DATE_TIME_DUE = 'DUE',
        DATE_TIME_START = 'DTSTART',
        DURATION = 'DURATION',
        FREE_BUSY_TIME = 'FREEBUSY',
        TIME_TRANSPARENCY = 'TRANSP',
        // TIME_ZONE_IDENTIFIER = 'TZID', // already defined as parameter name
        TIME_ZONE_NAME = 'TZNAME',
        TIME_ZONE_OFFSET_FROM = 'TZOFFSETFROM',
        TIME_ZONE_OFFSET_TO = 'TZOFFSETTO',
        TIME_ZONE_URL = 'TZURL',
        ATTENDEE = 'ATTENDEE',
        CONTACT = 'CONTACT',
        ORGANIZER = 'ORGANIZER',
        RECURRENCE_ID = 'RECURRENCE-ID',
        RELATED_TO = 'RELATED-TO',
        URL = 'URL',
        UNIQUE_IDENTIFIER = 'UID',
        EXCEPTION_DATE_TIMES = 'EXDATE',
        RECURRENCE_DATE_TIMES = 'RDATE',
        RECURRENCE_RULE = 'RRULE',
        ACTION = 'ACTION',
        REPEAT_COUNT = 'REPEAT',
        TRIGGER = 'TRIGGER',
        DATE_TIME_CREATED = 'CREATED',
        DATE_TIME_STAMP = 'DTSTAMP',
        LAST_MODIFIED = 'LAST-MODIFIED',
        SEQUENCE_NUMBER = 'SEQUENCE',
        REQUEST_STATUS = 'REQUEST-STATUS',
        PROPERTIES = [
        self::CALENDAR_SCALE => CalendarScale::class,
        self::METHOD => Method::class,
        self::PRODUCT_IDENTIFIER => ProductIdentifier::class,
        self::VERSION => Version::class,
        self::ATTACHMENT => Attachment::class,
        self::CATEGORIES => Categories::class,
        self::CLASSIFICATION => Classification::class,
        self::COMMENT => Comment::class,
        self::DESCRIPTION => Description::class,
        self::GEOGRAPHIC_POSITION => GeographicPosition::class,
        self::LOCATION => Location::class,
        self::PERCENT_COMPLETE => PercentComplete::class,
        self::PRIORITY => Priority::class,
        self::RESOURCES => Resources::class,
        self::STATUS => Status::class,
        self::SUMMARY => Summary::class,
        self::DATE_TIME_COMPLETED => DateTimeCompleted::class,
        self::DATE_TIME_END => DateTimeEnd::class,
        self::DATE_TIME_DUE => DateTimeDue::class,
        self::DATE_TIME_START => DateTimeStart::class,
        self::DURATION => Duration::class,
        self::FREE_BUSY_TIME => FreeBusyTime::class,
        self::TIME_TRANSPARENCY => TimeTransparency::class,
        self::TIME_ZONE_IDENTIFIER => TimeZoneIdentifier::class,
        self::TIME_ZONE_NAME => TimeZoneName::class,
        self::TIME_ZONE_OFFSET_FROM => TimeZoneOffsetFrom::class,
        self::TIME_ZONE_OFFSET_TO => TimeZoneOffsetTo::class,
        self::TIME_ZONE_URL => TimeZoneURL::class,
        self::ATTENDEE => Attendee::class,
        self::CONTACT => Contact::class,
        self::ORGANIZER => Organizer::class,
        self::RECURRENCE_ID => RecurrenceID::class,
        self::RELATED_TO => RelatedTo::class,
        self::URL => URL::class,
        self::UNIQUE_IDENTIFIER => UniqueIdentifier::class,
        self::EXCEPTION_DATE_TIMES => ExceptionDateTimes::class,
        self::RECURRENCE_DATE_TIMES => RecurrenceDateTimes::class,
        self::RECURRENCE_RULE => RecurrenceRule::class,
        self::ACTION => Action::class,
        self::REPEAT_COUNT => RepeatCount::class,
        self::TRIGGER => Trigger::class,
        self::DATE_TIME_CREATED => DateTimeCreated::class,
        self::DATE_TIME_STAMP => DateTimeStamp::class,
        self::LAST_MODIFIED => LastModified::class,
        self::SEQUENCE_NUMBER => SequenceNumber::class,
        self::REQUEST_STATUS => RequestStatus::class
    ];

    const
        BINARY = 'BINARY',
        BOOLEAN = 'BOOLEAN',
        CALENDAR_USER_ADDRESS = 'CAL-ADDRESS',
        DATE = 'DATE',
        DATE_TIME = 'DATE-TIME',
        DURATION_VALUE = 'DURATION',
        FLOAT = 'FLOAT',
        INTEGER = 'INTEGER',
        PERIOD_OF_TIME = 'PERIOD',
        RECURRENCE_RULE_VALUE = 'RECUR',
        TEXT = 'TEXT',
        TIME = 'TIME',
        URI = 'URI',
        UTCOffset = 'UTC-OFFSET',
        VALUES = [
        self::BINARY => Binary::class,
        self::BOOLEAN => Boolean::class,
        self::CALENDAR_USER_ADDRESS => CalendarUserAddress::class,
        self::DATE => Date::class,
        self::DATE_TIME => DateTime::class,
        self::DURATION => DurationValue::class,
        self::FLOAT => FloatValue::class,
        self::INTEGER => Integer::class,
        self::PERIOD_OF_TIME => PeriodOfTime::class,
        self::RECURRENCE_RULE_VALUE => RecurrenceRuleValue::class,
        self::TEXT => Text::class,
        self::TIME => Time::class,
        self::URI => URI::class,
        self::UTCOffset => UTCOffset::class
    ];

    const PROPERTY_VALUES = [
        self::CALENDAR_SCALE => Text::class,
        self::METHOD => Text::class,
        self::PRODUCT_IDENTIFIER => Text::class,
        self::VERSION => Text::class,
        self::ATTACHMENT => URI::class,
        self::CATEGORIES => Text::class,
        self::CLASSIFICATION => Text::class,
        self::COMMENT => Text::class,
        self::DESCRIPTION => Text::class,
        self::GEOGRAPHIC_POSITION => FloatValue::class,
        self::LOCATION => Text::class,
        self::PERCENT_COMPLETE => Integer::class,
        self::PRIORITY => Integer::class,
        self::RESOURCES => Text::class,
        self::STATUS => Text::class,
        self::SUMMARY => Text::class,
        self::DATE_TIME_COMPLETED => DateTime::class,
        self::DATE_TIME_END => [
            DateTime::class,
            Date::class
        ],
        self::DATE_TIME_DUE => [
            DateTime::class,
            Date::class
        ],
        self::DATE_TIME_START => [
            DateTime::class,
            Date::class
        ],
        self::DURATION => DurationValue::class,
        self::FREE_BUSY_TIME => PeriodOfTime::class,
        self::TIME_TRANSPARENCY => Text::class,
        self::TIME_ZONE_IDENTIFIER => Text::class,
        self::TIME_ZONE_NAME => Text::class,
        self::TIME_ZONE_OFFSET_FROM => UTCOffset::class,
        self::TIME_ZONE_OFFSET_TO => UTCOffset::class,
        self::TIME_ZONE_URL => URI::class,
        self::ATTENDEE => CalendarUserAddress::class,
        self::CONTACT => Text::class,
        self::ORGANIZER => CalendarUserAddress::class,
        self::RECURRENCE_ID => [
            DateTime::class,
            Date::class
        ],
        self::RELATED_TO => Text::class,
        self::URL => URI::class,
        self::UNIQUE_IDENTIFIER => Text::class,
        self::EXCEPTION_DATE_TIMES => [
            DateTime::class,
            Date::class
        ],
        self::RECURRENCE_DATE_TIMES => [
            DateTime::class,
            Date::class,
            PeriodOfTime::class
        ],
        self::RECURRENCE_RULE => RecurrenceRuleValue::class,
        self::ACTION => Text::class,
        self::REPEAT_COUNT => Integer::class,
        self::TRIGGER => [
            DurationValue::class,
            DateTime::class
        ],
        self::DATE_TIME_CREATED => DateTime::class,
        self::DATE_TIME_STAMP => DateTime::class,
        self::LAST_MODIFIED => DateTime::class,
        self::SEQUENCE_NUMBER => Integer::class,
        self::REQUEST_STATUS => Text::class
    ];

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.1 &sect;3.3.1. Binary */
    const
        _B_CHAR = '(?:' . ABNF::ALPHA . '|\\d|[\\+\\/])',
        _B_END = '(?:' . self::_B_CHAR . '{2,2}==|' . self::_B_CHAR . '{3,3}=)',
        PATTERN_BINARY = '(?:(?:' . self::_B_CHAR . '{4,4})*' . self::_B_END . '?)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.2 &sect;3.3.2. Boolean */
    const PATTERN_BOOLEAN = '(?:TRUE|FALSE)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.13 &sect;3.3.13. URI */
    const PATTERN_URI = RFC3986::URI;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.3 &sect3.3.3. Calendar User Address */
    const PATTERN_CALENDAR_USER_ADDRESS = self::PATTERN_URI;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.4 &sect;3.3.4. Date */
    const
        _DATE_MDAY = '(?:\\d{2,2})',
        _DATE_MONTH = '(?:\\d{2,2})',
        _DATE_FULLYEAR = '(?:\\d{4,4})',
        PATTERN_DATE = '(?:' . self::_DATE_FULLYEAR . self::_DATE_MONTH . self::_DATE_MDAY . ')';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.12 &sect;3.3.12 Time */
    const
        _TIME_UTC = 'Z',
        _TIME_SECOND = '(?:\\d{2,2})',
        _TIME_MINUTE = '(?:\\d{2,2})',
        _TIME_HOUR = '(?:\\d{2,2})',
        PATTERN_TIME = '(?:' . self::_TIME_HOUR . self::_TIME_MINUTE . self::_TIME_SECOND . self::_TIME_UTC . '?)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.5 &sect;3.3.5. Date-Time */
    const PATTERN_DATE_TIME = '(?:' . self::PATTERN_DATE . 'T' . self::PATTERN_TIME . ')';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.6 &sect;3.3.6. Duration */
    const
        _DUR_SECOND = '(?:\\d+S)',
        _DUR_MINUTE = '(?:\\d+M(?:' . self::_DUR_SECOND . ')?)',
        _DUR_HOUR = '(?:\\d+H(?:' . self::_DUR_MINUTE . ')?)',
        _DUR_DAY = '(?:\\d+D:)',
        _DUR_WEEK = '(?:\\d+W)',
        _DUR_TIME = '(?:T(?:' . self::_DUR_HOUR . '|' . self::_DUR_MINUTE . '|' . self::_DUR_SECOND . '))',
        _DUR_DATE = '(?:' . self::_DUR_DAY . '(?:' . self::_DUR_TIME . ')?)',
        PATTERN_DUR_VALUE = '(?:[+-]?P(?:' . self::_DUR_DATE . '|' . self::_DUR_TIME . '|' . self::_DUR_WEEK . '))';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.7 &sect;3.3.7. FLoat */
    const PATTERN_FLOAT = '(?:[+\\-]?\\d+\\.\\d+)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.8 &sect;3.3.8. Integer */
    const PATTERN_INTEGER = '(?:[+\\-]?\\d+)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.9 &sect;3.3.9. Period of Time */
    const
        _PERIOD_EXPLICIT = '(?:' . self::PATTERN_DATE_TIME . '|' . self::PATTERN_DATE_TIME . ')',
        _PERIOD_START = '(?:' . self::PATTERN_DATE_TIME . '|' . self::PATTERN_DUR_VALUE . ')',
        _PERIOD_VALUE = '(?:' . self::_PERIOD_EXPLICIT . '|' . self::_PERIOD_START . ')',
        PATTERN_PERIOD_OF_TIME = '(?:' . self::_PERIOD_EXPLICIT . '|' . self::_PERIOD_START . ')';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.10 &sect;3.3.10. Recrurrence Rule */
    const
        _ORDYRDAY = '(?:\\d{1,3})',
        _YEARDAYNUM = '(?:[+\\-]?' . self::_ORDYRDAY . ')',
        _SETPOSDAY = self::_YEARDAYNUM,
        _BYSPLIST = '(?:' . self::_SETPOSDAY . '(?:,' . self::_SETPOSDAY . ')*)',
        _MONTHNUM = '(?:\\d{1,2})',
        _BYMOLIST = '(?:' . self::_MONTHNUM . '(?:,' . self::_MONTHNUM . ')*)',
        _ORDWK = '(?:\\d{1,2})',
        _WEEKNUM = '(?:(?:[+\\-]?)' . self::_ORDWK . ')',
        _BYWKNOLIST = '(?:' . self::_WEEKNUM . '(?:,' . self::_WEEKNUM . ')*)',
        _BYYRDAYLIST = '(?:' . self::_YEARDAYNUM . '(?:,' . self::_YEARDAYNUM . ')*)',
        _ORDMODAY = '(?:\\d{1,2})',
        _MONTHDAYNUM = '(?:[+\\-]?)' . self::_ORDMODAY,
        _BYMODAYLIST = self::_MONTHDAYNUM . '(?:,' . self::_MONTHDAYNUM . ')*',
        _WEEKDAY = '(?:SU|MO|TU|WE|TH|FR|SA)',
        _WEEKDAYNUM = '(?:[+\\-]?' . self::_ORDWK . ')?' . self::_WEEKDAY,
        _BYWDAYLIST = '(?:' . self::_WEEKDAYNUM . '(?:,' . self::_WEEKDAYNUM . ')*)',
        _HOUR = '(?:\\d{1,2})',
        _BYHRLIST = '(?:' . self::_HOUR . '(?:,' . self::_HOUR . ')*)',
        _MINUTES = '(?:\\d{1,2})',
        _BYMINLIST = '(?:' . self::_MINUTES . '(?:,' . self::_MINUTES . ')*)',
        _SECONDS = '(?:\\d{1,2})',
        _BYSECLIST = '(?:' . self::_SECONDS . '(?:,' . self::_SECONDS . ')*)',
        _ENDDATE = '(?:' . self::PATTERN_DATE . '|' . self::PATTERN_DATE_TIME . ')',
        SECONDLY = 'SECONDLY',
        MINUTELY = 'MINUTELY',
        HOURLY = 'HOURLY',
        DAILY = 'DAILY',
        WEEKLY = 'WEEKLY',
        MONTHLY = 'MONTHLY',
        YEARLY = 'YEARLY',
        _FREQ = '(?:' . self::SECONDLY . '|' . self::MINUTELY . '|' . self::HOURLY . '|' . self::DAILY . '|' . self::WEEKLY . '|' . self::MONTHLY . '|' . self::YEARLY . ')',
        FREQ = 'FREQ',
        UNTIL = 'UNTIL',
        COUNT = 'COUNT',
        INTERVAL = 'INTERVAL',
        BYSECOND = 'BYSECOND',
        BYMINUTE = 'BYMINUTE',
        BYHOUR = 'BYHOUR',
        BYDAY = 'BYDAY',
        BYMONTHDAY = 'BYMONTHDAY',
        BYYEARDAY = 'BYYEARDAY',
        BYWEEKNO = 'BYWEEKNO',
        BYMONTH = 'BYMONTH',
        BYSETPOS = 'BYSETPOS',
        WKST = 'WKST',
        RECURRENCE_RULES_PARTS = [
        self::FREQ,
        self::UNTIL,
        self::COUNT,
        self::INTERVAL,
        self::WKST,
        self::BYMONTH,
        self::BYWEEKNO,
        self::BYYEARDAY,
        self::BYMONTHDAY,
        self::BYDAY,
        self::BYHOUR,
        self::BYMINUTE,
        self::BYSECOND,
        self::BYSETPOS
    ],
        RECURRENCE_RULE_PRECEDENCE = [
        self::BYMONTH,
        self::BYWEEKNO,
        self::BYYEARDAY,
        self::BYMONTHDAY,
        self::BYDAY,
        self::BYHOUR,
        self::BYMINUTE,
        self::BYSECOND,
        self::BYSETPOS
    ],
        recur_rule_part =
        '(?:' .
        self::FREQ . self::FIELD_SEPARATOR . self::_FREQ . '|' .
        self::UNTIL . self::FIELD_SEPARATOR . self::_ENDDATE . '|' .
        self::COUNT . self::FIELD_SEPARATOR . '\\d+|' .
        self::INTERVAL . self::FIELD_SEPARATOR . '\\d+|' .
        self::BYSECOND . self::FIELD_SEPARATOR . self::_BYSECLIST . '|' .
        self::BYMINUTE . self::FIELD_SEPARATOR . self::_BYMINLIST . '|' .
        self::BYHOUR . self::FIELD_SEPARATOR . self::_BYHRLIST . '|' .
        self::BYDAY . self::FIELD_SEPARATOR . self::_BYWDAYLIST . '|' .
        self::BYMONTHDAY . self::FIELD_SEPARATOR . self::_BYMODAYLIST . '|' .
        self::BYYEARDAY . self::FIELD_SEPARATOR . self::_BYYRDAYLIST . '|' .
        self::BYWEEKNO . self::FIELD_SEPARATOR . self::_BYWKNOLIST . '|' .
        self::BYMONTH . self::FIELD_SEPARATOR . self::_BYMOLIST . '|' .
        self::BYSETPOS . self::FIELD_SEPARATOR . self::_BYSPLIST . '|' .
        self::WKST . self::FIELD_SEPARATOR . self::_WEEKDAY .
        ')',
        PATTERN_RECURRENCE_RULE_VALUE = '(?:' . self::recur_rule_part . '(?:;' . self::recur_rule_part . ')*)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.13 &sect;3.3.13. Text */
    const
        _TSAFE_CHAR = '(?:' . self::WSP . '|[\\x21\\x23-\\x2B\\x2D-\\x39\\x3C-\\x5B\\x5D-\\x7E]|' . self::NON_US_ASCII . ')',
        ESCAPE_CHAR = '\\',
        _ESCAPED_CHAR = '(?:' . self::ESCAPE_CHAR . self::ESCAPE_CHAR . '|' . self::ESCAPE_CHAR . ';|' . self::ESCAPE_CHAR . ',|' . self::ESCAPE_CHAR . '[Nn])',
        PATTERN_TEXT = '(?:(?:' . self::_TSAFE_CHAR . '|[:"]|' . self::_ESCAPED_CHAR . ')*)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.14 &sect;3.3.14. UTC Offset */
    const
        _TIME_NUMZONE = '[+\\-]' . self::_TIME_HOUR . self::_TIME_MINUTE . self::_TIME_SECOND . '?',
        PATTERN_UTC_OFFSET = self::_TIME_NUMZONE;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3 &sect;3.3. Property Value Data Types */
    const PROPERTY_VALUE_DATA_TYPES = [
        Binary::class => self::PATTERN_BINARY,
        Boolean::class => self::PATTERN_BOOLEAN,
        CalendarUserAddress::class => self::PATTERN_CALENDAR_USER_ADDRESS,
        Date::class => self::PATTERN_DATE,
        DateTime::class => self::PATTERN_DATE_TIME,
        DurationValue::class => self::PATTERN_DUR_VALUE,
        FloatValue::class => self::PATTERN_FLOAT,
        Integer::class => self::PATTERN_INTEGER,
        PeriodOfTime::class => self::PATTERN_PERIOD_OF_TIME,
        RecurrenceRuleValue::class => self::PATTERN_RECURRENCE_RULE_VALUE,
        Text::class => self::PATTERN_TEXT,
        Time::class => self::PATTERN_TIME,
        URI::class => self::PATTERN_URI,
        UTCOffset::class => self::PATTERN_UTC_OFFSET
    ];
}
