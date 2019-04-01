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

    /** @link https://tools.ietf.org/html/rfc5545#section-2.1 &sect;3.1. Content Lines */
    const
        CONTROL = '[\\x00-\\x08\\x0A-\\x1F\\x7F]',
        NON_US_ASCII = '(?:' . RFC3629::UTF8_2 . '|' . RFC3629::UTF8_3 . '|' . RFC3629::UTF8_4 . ')',
        VALUE_CHAR = '(?:' . self::WSP . '|[\\x21-\\x7E]|' . self::NON_US_ASCII . ')',
        SAFE_CHAR = '(?:' . self::WSP . '|[\\x21\\x23-\\x2B\\x2D-\\x39\\x3C-\\x7E]|' . self::NON_US_ASCII . ')',
        QSAFE_CHAR = '(?:' . self::WSP . '|[\\x21\\x23-\\x7E]|' . self::NON_US_ASCII . ')',
        quoted_string = self::DQUOTE . self::QSAFE_CHAR . '*' . self::DQUOTE,
        value = self::VALUE_CHAR . '*',
        vendorid = '(?:' . ABNF::ALPHA . '|\\d){3,}',
        iana_token = '(?:' . ABNF::ALPHA . '|\\d|-' . ')',
        x_name = 'X-' . self::vendorid . '?(?:' . ABNF::ALPHA . '|\\d|-)+',
        paramtext = self::SAFE_CHAR . '*',
        param_value = '(?:' . self::paramtext . '|' . self::quoted_string . ')',
        param_name = '(?:' . self::iana_token . '|' . self::x_name . ')',
        param = self::param_name . '=' . self::param_value . '(?:,' . self::param_value . ')*',
        name = '(?:' . self::iana_token . '|' . self::x_name . ')',
        contentline = self::name . '(?:;' . self::param . '):' . self::value . self::CRLF;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.2 &sect;3.2. Property Parameters */
    const
        AlternateTextRepresentation = 'ALTREP',
        CommonName = 'CN',
        CalendarUserType = 'CUTYPE',
        Delegators = 'DELEGATED-FROM',
        Delegatees = 'DELEGATED-TO',
        DirectoryEntryReference = 'DIR',
        InlineEncoding = 'ENCODING',
        FormatType = 'FMTTYPE',
        FreeBusyTimeType = 'FBTYPE',
        Language = 'LANGUAGE',
        GroupOrListMembership = 'MEMBER',
        ParticipationStatus = 'PARTSTAT',
        RecurrenceIdentifierRange = 'RANGE',
        AlarmTriggerRelationship = 'RELATED',
        RelationshipType = 'RELTYPE',
        ParticipationRole = 'ROLE',
        RSVPExpectation = 'RSVP',
        SentBy = 'SENT-BY',
        // TimeZoneIdentifier already defined as property label
        ValueDataTypes = 'VALUE',
        PROPERTY_PARAMETERS = [
        self::AlternateTextRepresentation => AlternateTextRepresentation::class,
        self::CommonName => CommonName::class,
        self::CalendarUserType => CalendarUserType::class,
        self::Delegators => Delegators::class,
        self::Delegatees => Delegatees::class,
        self::DirectoryEntryReference => DirectoryEntryReference::class,
        self::InlineEncoding => InlineEncoding::class,
        self::FormatType => FormatType::class,
        self::FreeBusyTimeType => FreeBusyTimeType::class,
        self::Language => Language::class,
        self::GroupOrListMembership => GroupOrListMembership::class,
        self::ParticipationStatus => ParticipationStatus::class,
        self::RecurrenceIdentifierRange => RecurrenceIdentifierRange::class,
        self::AlarmTriggerRelationship => AlarmTriggerRelationship::class,
        self::RelationshipType => RelationshipType::class,
        self::ParticipationRole => ParticipationRole::class,
        self::RSVPExpectation => RSVPExpectation::class,
        self::SentBy => SentBy::class,
        self::TimeZoneIdentifier => TimeZoneIdentifierParameter::class,
        self::ValueDataTypes => ValueDataTypes::class
    ];

    /** @link https://tools.ietf.org/html/rfc5545#section-3.2 &sect;3.2. Property Parameters */
    const PROPERTY_PARAMETER_VALUES = [
        self::AlternateTextRepresentation => URI::class,
        self::CommonName => Text::class,
        self::CalendarUserType => Text::class,
        self::Delegators => CalendarUserAddress::class,
        self::Delegatees => CalendarUserAddress::class,
        self::DirectoryEntryReference => URI::class,
        self::InlineEncoding => Text::class,
        self::FormatType => Text::class,
        self::FreeBusyTimeType => Text::class,
        self::Language => Text::class,
        self::GroupOrListMembership => CalendarUserAddress::class,
        self::ParticipationStatus => Text::class,
        self::RecurrenceIdentifierRange => Text::class,
        self::AlarmTriggerRelationship => Text::class,
        self::RelationshipType => Text::class,
        self::ParticipationRole => Text::class,
        self::RSVPExpectation => Boolean::class,
        self::SentBy => CalendarUserAddress::class,
        self::TimeZoneIdentifier => Text::class,
        self::ValueDataTypes => Text::class
    ];

    const
        Calendar = 'VCALENDAR',
        Event = 'VEVENT',
        ToDo = 'VTODO',
        Journal = 'VJOURNAL',
        FreeBusy = 'VFREEBUSY',
        TimeZone = 'VTIMEZONE',
        StandardTime = 'STANDARD',
        DaylightSavingTime = 'DAYLIGHT',
        Alarm = 'VALARM',
        COMPONENTS = [
        self::Calendar => Calendar::class,
        self::Event => Event::class,
        self::ToDo => ToDo::class,
        self::Journal => Journal::class,
        self::FreeBusy => FreeBusy::class,
        self::TimeZone => TimeZone::class,
        self::StandardTime => StandardTime::class,
        self::DaylightSavingTime => DaylightSavingTime::class,
        self::Alarm => Alarm::class
    ];

    const
        CalendarScale = 'CALSCALE',
        Method = 'METHOD',
        ProductIdentifier = 'PRODID',
        Version = 'VERSION',
        Attachment = 'ATTACH',
        Categories = 'CATEGORIES',
        Classification = 'CLASS',
        Comment = 'COMMENT',
        Description = 'DESCRIPTION',
        GeographicPosition = 'GEO',
        Location = 'LOCATION',
        PercentComplete = 'PERCENT-COMPLETE',
        Priority = 'PRIORITY',
        Resources = 'RESOURCES',
        Status = 'STATUS',
        Summary = 'SUMMARY',
        DateTimeCompleted = 'COMPLETED',
        DateTimeEnd = 'DTEND',
        DateTimeDue = 'DUE',
        DateTimeStart = 'DTSTART',
        Duration = 'DURATION',
        FreeBusyTime = 'FREEBUSY',
        TimeTransparency = 'TRANSP',
        TimeZoneIdentifier = 'TZID',
        TimeZoneName = 'TZNAME',
        TimeZoneOffsetFrom = 'TZOFFSETFROM',
        TimeZoneOffsetTo = 'TZOFFSETTO',
        TimeZoneURL = 'TZURL',
        Attendee = 'ATTENDEE',
        Contact = 'CONTACT',
        Organizer = 'ORGANIZER',
        RecurrenceID = 'RECURRENCE-ID',
        RelatedTo = 'RELATED-TO',
        URL = 'URL',
        UniqueIdentifier = 'UID',
        ExceptionDateTimes = 'EXDATE',
        RecurrenceDateTimes = 'RDATE',
        RecurrenceRule = 'RRULE',
        Action = 'ACTION',
        RepeatCount = 'REPEAT',
        Trigger = 'TRIGGER',
        DateTimeCreated = 'CREATED',
        DateTimeStamp = 'DTSTAMP',
        LastModified = 'LAST-MODIFIED',
        SequenceNumber = 'SEQUENCE',
        RequestStatus = 'REQUEST-STATUS',
        PROPERTIES = [
        self::CalendarScale => CalendarScale::class,
        self::Method => Method::class,
        self::ProductIdentifier => ProductIdentifier::class,
        self::Version => Version::class,
        self::Attachment => Attachment::class,
        self::Categories => Categories::class,
        self::Classification => Classification::class,
        self::Comment => Comment::class,
        self::Description => Description::class,
        self::GeographicPosition => GeographicPosition::class,
        self::Location => Location::class,
        self::PercentComplete => PercentComplete::class,
        self::Priority => Priority::class,
        self::Resources => Resources::class,
        self::Status => Status::class,
        self::Summary => Summary::class,
        self::DateTimeCompleted => DateTimeCompleted::class,
        self::DateTimeEnd => DateTimeEnd::class,
        self::DateTimeDue => DateTimeDue::class,
        self::DateTimeStart => DateTimeStart::class,
        self::Duration => Duration::class,
        self::FreeBusyTime => FreeBusyTime::class,
        self::TimeTransparency => TimeTransparency::class,
        self::TimeZoneIdentifier => TimeZoneIdentifier::class,
        self::TimeZoneName => TimeZoneName::class,
        self::TimeZoneOffsetFrom => TimeZoneOffsetFrom::class,
        self::TimeZoneOffsetTo => TimeZoneOffsetTo::class,
        self::TimeZoneURL => TimeZoneURL::class,
        self::Attendee => Attendee::class,
        self::Contact => Contact::class,
        self::Organizer => Organizer::class,
        self::RecurrenceID => RecurrenceID::class,
        self::RelatedTo => RelatedTo::class,
        self::URL => URL::class,
        self::UniqueIdentifier => UniqueIdentifier::class,
        self::ExceptionDateTimes => ExceptionDateTimes::class,
        self::RecurrenceDateTimes => RecurrenceDateTimes::class,
        self::RecurrenceRule => RecurrenceRule::class,
        self::Action => Action::class,
        self::RepeatCount => RepeatCount::class,
        self::Trigger => Trigger::class,
        self::DateTimeCreated => DateTimeCreated::class,
        self::DateTimeStamp => DateTimeStamp::class,
        self::LastModified => LastModified::class,
        self::SequenceNumber => SequenceNumber::class,
        self::RequestStatus => RequestStatus::class
    ];

    const
        Binary = 'BINARY',
        Boolean = 'BOOLEAN',
        CalendarUserAddress = 'CAL-ADDRESS',
        Date = 'DATE',
        DateTime = 'DATE-TIME',
        DurationValue = 'DURATION',
        Float = 'FLOAT',
        Integer = 'INTEGER',
        PeriodOfTime = 'PERIOD',
        RecurrenceRuleValue = 'RECUR',
        Text = 'TEXT',
        Time = 'TIME',
        URI = 'URI',
        UTCOffset = 'UTC-OFFSET',
        VALUES = [
        self::Binary => Binary::class,
        self::Boolean => Boolean::class,
        self::CalendarUserAddress => CalendarUserAddress::class,
        self::Date => Date::class,
        self::DateTime => DateTime::class,
        self::Duration => DurationValue::class,
        self::Float => FloatValue::class,
        self::Integer => Integer::class,
        self::PeriodOfTime => PeriodOfTime::class,
        self::RecurrenceRuleValue => RecurrenceRuleValue::class,
        self::Text => Text::class,
        self::Time => Time::class,
        self::URI => URI::class,
        self::UTCOffset => UTCOffset::class
    ];

    const PROPERTY_VALUES = [
        self::CalendarScale => Text::class,
        self::Method => Text::class,
        self::ProductIdentifier => Text::class,
        self::Version => Text::class,
        self::Attachment => URI::class,
        self::Categories => Text::class,
        self::Classification => Text::class,
        self::Comment => Text::class,
        self::Description => Text::class,
        self::GeographicPosition => FloatValue::class,
        self::Location => Text::class,
        self::PercentComplete => Integer::class,
        self::Priority => Integer::class,
        self::Resources => Text::class,
        self::Status => Text::class,
        self::Summary => Text::class,
        self::DateTimeCompleted => DateTime::class,
        self::DateTimeEnd => [
            DateTime::class,
            Date::class
        ],
        self::DateTimeDue => [
            DateTime::class,
            Date::class
        ],
        self::DateTimeStart => [
            DateTime::class,
            Date::class
        ],
        self::Duration => DurationValue::class,
        self::FreeBusyTime => PeriodOfTime::class,
        self::TimeTransparency => Text::class,
        self::TimeZoneIdentifier => Text::class,
        self::TimeZoneName => Text::class,
        self::TimeZoneOffsetFrom => UTCOffset::class,
        self::TimeZoneOffsetTo => UTCOffset::class,
        self::TimeZoneURL => URI::class,
        self::Attendee => CalendarUserAddress::class,
        self::Contact => Text::class,
        self::Organizer => CalendarUserAddress::class,
        self::RecurrenceID => [
            DateTime::class,
            Date::class
        ],
        self::RelatedTo => Text::class,
        self::URL => URI::class,
        self::UniqueIdentifier => Text::class,
        self::ExceptionDateTimes => [
            DateTime::class,
            Date::class
        ],
        self::RecurrenceDateTimes => [
            DateTime::class,
            Date::class,
            PeriodOfTime::class
        ],
        self::RecurrenceRule => RecurrenceRuleValue::class,
        self::Action => Text::class,
        self::RepeatCount => Integer::class,
        self::Trigger => [
            DurationValue::class,
            DateTime::class
        ],
        self::DateTimeCreated => DateTime::class,
        self::DateTimeStamp => DateTime::class,
        self::LastModified => DateTime::class,
        self::SequenceNumber => Integer::class,
        self::RequestStatus => Text::class
    ];

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.1 &sect;3.3.1. Binary */
    const
        b_char = '(?:' . ABNF::ALPHA . '|\\d|[\\+\\/])',
        b_end = '(?:' . self::b_char . '{2,2}==|' . self::b_char . '{3,3}=)',
        binary = '(?:(?:' . self::b_char . '{4,4})*' . self::b_end . '?)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.2 &sect;3.3.2. Boolean */
    const boolean = '(?:TRUE|FALSE)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.13 &sect;3.3.13. URI */
    const uri = RFC3986::URI;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.3 &sect3.3.3. Calendar User Address */
    const cal_address = self::uri;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.4 &sect;3.3.4. Date */
    const
        date_mday = '(?:\\d{2,2})',
        date_month = '(?:\\d{2,2})',
        date_fullyear = '(?:\\d{4,4})',
        date = '(?:' . self::date_fullyear . self::date_month . self::date_mday . ')';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.12 &sect;3.3.12 Time */
    const
        time_utc = 'Z',
        time_second = '(?:\\d{2,2})',
        time_minute = '(?:\\d{2,2})',
        time_hour = '(?:\\d{2,2})',
        time = '(?:' . self::time_hour . self::time_minute . self::time_second . self::time_utc . '?)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.5 &sect;3.3.5. Date-Time */
    const date_time = '(?:' . self::date . 'T' . self::time . ')';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.6 &sect;3.3.6. Duration */
    const
        dur_second = '(?:\\d+S)',
        dur_minute = '(?:\\d+M(?:' . self::dur_second . ')?)',
        dur_hour = '(?:\\d+H(?:' . self::dur_minute . ')?)',
        dur_day = '(?:\\d+D:)',
        dur_week = '(?:\\d+W)',
        dur_time = '(?:T(?:' . self::dur_hour . '|' . self::dur_minute . '|' . self::dur_second . '))',
        dur_date = '(?:' . self::dur_day . '(?:' . self::dur_time . ')?)',
        dur_value = '(?:[+-]?P(?:' . self::dur_date . '|' . self::dur_time . '|' . self::dur_week . '))';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.7 &sect;3.3.7. FLoat */
    const float = '(?:[+\\-]?\\d+\\.\\d+)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.8 &sect;3.3.8. Integer */
    const integer = '(?:[+\\-]?\\d+)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.9 &sect;3.3.9. Period of Time */
    const
        period_explicit = '(?:' . self::date_time . '|' . self::date_time . ')',
        period_start = '(?:' . self::date_time . '|' . self::dur_value . ')',
        period_value = '(?:' . self::period_explicit . '|' . self::period_start . ')',
        period = '(?:' . self::period_explicit . '|' . self::period_start . ')';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.10 &sect;3.3.10. Recrurrence Rule */
    const
        ordyrday = '(?:\\d{1,3})',
        yeardaynum = '(?:[+\\-]?' . self::ordyrday . ')',
        setposday = self::yeardaynum,
        bysplist = '(?:' . self::setposday . '(?:,' . self::setposday . ')*)',
        monthnum = '(?:\\d{1,2})',
        bymolist = '(?:' . self::monthnum . '(?:,' . self::monthnum . ')*)',
        ordwk = '(?:\\d{1,2})',
        weeknum = '(?:(?:[+\\-]?)' . self::ordwk . ')',
        bywknolist = '(?:' . self::weeknum . '(?:,' . self::weeknum . ')*)',
        byyrdaylist = '(?:' . self::yeardaynum . '(?:,' . self::yeardaynum . ')*)',
        ordmoday = '(?:\\d{1,2})',
        monthdaynum = '(?:[+\\-]?)' . self::ordmoday,
        bymodaylist = self::monthdaynum . '(?:,' . self::monthdaynum . ')*',
        weekday = '(?:SU|MO|TU|WE|TH|FR|SA)',
        weekdaynum = '(?:[+\\-]?' . self::ordwk . ')?' . self::weekday,
        bywdaylist = '(?:' . self::weekdaynum . '(?:,' . self::weekdaynum . ')*)',
        hour = '(?:\\d{1,2})',
        byhrlist = '(?:' . self::hour . '(?:,' . self::hour . ')*)',
        minutes = '(?:\\d{1,2})',
        byminlist = '(?:' . self::minutes . '(?:,' . self::minutes . ')*)',
        seconds = '(?:\\d{1,2})',
        byseclist = '(?:' . self::seconds . '(?:,' . self::seconds . ')*)',
        enddate = '(?:' . self::date . '|' . self::date_time . ')',
        freq = '(?:SECONDLY|MINUTELY|HOURLY|DAILY|WEEKLY|MONTHLY|YEARLY)',
        recur_rule_part =
        '(?:' .
        'FREQ=' . self::freq . '|' .
        'UNTIL=' . self::enddate . '|' .
        'COUNT=\\d+|' .
        'INTERVA:=\\d+|' .
        'BYSECOND=' . self::byseclist . '|' .
        'BYMINUTE=' . self::byminlist . '|' .
        'BYHOUR=' . self::byhrlist . '|' .
        'BYDAY=' . self::bywdaylist . '|' .
        'BYMONTHDAY=' . self::bymodaylist . '|' .
        'BYYEARDAY=' . self::byyrdaylist . '|' .
        'BYWEEKNO=' . self::bywknolist . '|' .
        'BYMONTH=' . self::bymolist . '|' .
        'BYSETPOS=' . self::bysplist . '|' .
        'WKST=' . self::weekday .
        ')',
        recur = '(?:' . self::recur_rule_part . '(?:;' . self::recur_rule_part . ')*)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.11 &sect;3.3.13. Text */
    const
        TSAFE_CHAR = '(?:' . self::WSP . '|[\\x21\\x23-\\x2B\\x2D-\\x39\\x3C-\\x5B\\x5D-\\x7E]|' . self::NON_US_ASCII . ')',
        ESCAPED_CHAR = '(?:\\\\|\\;|\\,|\\[Nn])',
        text = '(?:(?:' . self::TSAFE_CHAR . '|[:"]|' . self::ESCAPED_CHAR . ')*)';

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3.14 &sect;3.3.14. UTC Offset */
    const
        time_numzone = '[+\\-]' . self::time_hour . self::time_minute . self::time_second . '?',
        utc_offset = self::time_numzone;

    /** @link https://tools.ietf.org/html/rfc5545#section-3.3 &sect;3.3. Property Value Data Types */
    const PROPERTY_VALUE_DATA_TYPES = [
        Binary::class => self::binary,
        Boolean::class => self::boolean,
        CalendarUserAddress::class => self::cal_address,
        Date::class => self::date,
        DateTime::class => self::date_time,
        DurationValue::class => self::dur_value,
        FloatValue::class => self::float,
        Integer::class => self::integer,
        PeriodOfTime::class => self::period,
        RecurrenceRuleValue::class => self::recur,
        Text::class => self::text,
        Time::class => self::time,
        URI::class => self::uri,
        UTCOffset::class => self::utc_offset
    ];
}
