<?php


namespace Battis\Calendar\Standards;

/**
 * @link https://tools.ietf.org/html/rfc3986 RFC 3986 URI Generic Syntax
 */
interface RFC3986
{
    const
        PCT_ENCODED = '%' . ABNF::HEXDIG . ABNF::HEXDIG,
        GEN_DELIMS = '[:\\/\\?#\\]\\]@]',
        SUB_DELIMS = '[\\!\\$\\&\'\\(\\)\\*\\+,;=]',
        UNRESERVED = '(?:' . ABNF::ALPHA . '|\\d|[\\-\\._\\~])',
        SCHEME = '(?:' . ABNF::ALPHA . '(?:' . ABNF::ALPHA . '|\\d|[+-.])*)',
        USERINFO = '(?:(?:' . self::UNRESERVED . '|' . self::PCT_ENCODED . '|' . self::SUB_DELIMS . '|:)*)',
        REG_NAME = '(?:(?:' . self::UNRESERVED . '|' . self::PCT_ENCODED . '|' . self::SUB_DELIMS . ')*)',
        HOST = '(?:' . self::IP_LITERAL . '|' . self::IP_V4ADDRESS . '|' . self::REG_NAME . ')',
        DEC_OCTET =
        '(?:' .
        '\\d|' .
        '[\\x31-\\x39]\\d|' .
        '1\\d{2,2}|' .
        '2[\\x30-\\x34]\\d|' .
        '25[\\x30-\\x35]' .
        ')',
        IP_V4ADDRESS = '(?:' . self::DEC_OCTET . '\\.' . self::DEC_OCTET . '\\.' . self::DEC_OCTET . '\\.' . self::DEC_OCTET . ')',
        H16 = '(?:(?:' . ABNF::HEXDIG . '{4,4})+)',
        LS32 = '(?:' . self::H16 . ':' . self::H16 . '|' . self::IP_V4ADDRESS . ')',
        IP_V6ADDRESS =
        '(?:' .
        '(?:' . self::H16 . ':){6,6}' . self::LS32 . '|' .
        '::(?:' . self::H16 . ':){5,5}' . self::LS32 . '|' .
        '(?:' . self::H16 . ')?::(?:' . self::H16 . ':){4,4}' . self::LS32 . '|' .
        '(?:(?:' . self::H16 . ':){,1}' . self::H16 . ')?::(:' . self::H16 . ':){3,3}' . self::LS32 . '|' .
        '(?:(?:' . self::H16 . ':){,2}' . self::H16 . ')?::(?:' . self::H16 . ':){2,2}' . self::LS32 . '|' .
        '(?:(?:' . self::H16 . ':){,3}' . self::H16 . ')?::' . self::H16 . ':' . self::LS32 . '|' .
        '(?:(?:' . self::H16 . ':){,4}' . self::H16 . ')?::' . self::LS32 . '|' .
        '(?:(?:' . self::H16 . ':){,5}' . self::H16 . ')?::' . self::H16 . '|' .
        '(?:(?:' . self::H16 . ':){,6}' . self::H16 . ')?::' .
        ')',
        IP_VFUTURE = '(?:v' . ABNF::HEXDIG . '+\\.(?:' . self::UNRESERVED . '|' . self::SUB_DELIMS . '|:)+)',
        IP_LITERAL = '(?:\\[(?:' . self::IP_V6ADDRESS . '|' . self::IP_VFUTURE . ')\\])',
        PORT = '(?:\\d*)',
        AUTHORITY = '(?:(?:' . self::USERINFO . '@)?' . self::HOST . '(?::' . self::PORT . ')?)',
        PCHAR = '(?:' . self::UNRESERVED . '|' . self::PCT_ENCODED . '|' . self::SUB_DELIMS . '|@)',
        SEGMENT_NZ_NC = '(?:(?:' . self::UNRESERVED . '|' . self::PCT_ENCODED . '|' . self::SUB_DELIMS . '@)+)',
        SEGMENT_NZ = '(?:' . self::PCHAR . '+)',
        SEGMENT = '(?:' . self::PCHAR . '*)',
        PATH_EMPTY = '(?:' . self::PCHAR . '{0,0})',
        PATH_ROOTLESS = '(?:' . self::SEGMENT_NZ . '(?:\\/' . self::SEGMENT . ')*)',
        PATH_NOSCHEME = '(?:' . self::SEGMENT_NZ_NC . '(?:\\/' . self::SEGMENT . ')*)',
        PATH_ABSOLUTE = '(?:\\/(?:' . self::SEGMENT_NZ . '(?:\\/' . self::SEGMENT . ')*)?)',
        PATH_ABEMPTY = '(?:(?:\\/' . self::SEGMENT . ')*)',
        PATH = '(?:' . self::PATH_ABEMPTY . '|' . self::PATH_ABSOLUTE . '|' . self::PATH_NOSCHEME . '|' . self::PATH_ROOTLESS . '|' . self::PATH_EMPTY . ')',
        HIER_PART = '(?:\\/\\/' . self::AUTHORITY . self::PATH_ABEMPTY . '|' . self::PATH_ABSOLUTE . '|' . self::PATH_ROOTLESS . '|' . self::PATH_EMPTY . ')',
        QUERY = '(?:(?:' . self::PCHAR . '|\\/|\\?)*)',
        FRAGMENT = '(?:(?:' . self::PCHAR . '|\\/|\\?)*)',
        URI = '(?:' . self::SCHEME . ':' . self::HIER_PART . '(?:\\?' . self::QUERY . ')?(?:#' . self::FRAGMENT . ')?)';
}
