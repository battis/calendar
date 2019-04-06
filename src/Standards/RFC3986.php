<?php


namespace Battis\Calendar\Standards;

/**
 * @link https://tools.ietf.org/html/rfc3986 RFC 3986 URI Generic Syntax
 */
interface RFC3986
{
    const
        pct_encoded = '%' . ABNF::HEXDIG . ABNF::HEXDIG,
        gen_delims = '[:\\/\\?#\\]\\]@]',
        sub_delims = '[\\!\\$\\&\'\\(\\)\\*\\+,;=]',
        unreserved = '(?:' . ABNF::ALPHA . '|\\d|[\\-\\._\\~])',
        scheme = '(?:' . ABNF::ALPHA . '(?:' . ABNF::ALPHA . '|\\d|[+-.])*)',
        userinfo = '(?:(?:' . self::unreserved . '|' . self::pct_encoded . '|' . self::sub_delims . '|:)*)',
        reg_name = '(?:(?:' . self::unreserved . '|' . self::pct_encoded . '|' . self::sub_delims . ')*)',
        host = '(?:' . self::IP_literal . '|' . self::IPv4address . '|' . self::reg_name . ')',
        dec_octet =
        '(?:' .
        '\\d|' .
        '[\\x31-\\x39]\\d|' .
        '1\\d{2,2}|' .
        '2[\\x30-\\x34]\\d|' .
        '25[\\x30-\\x35]' .
        ')',
        IPv4address = '(?:' . self::dec_octet . '\\.' . self::dec_octet . '\\.' . self::dec_octet . '\\.' . self::dec_octet . ')',
        h16 = '(?:(?:' . ABNF::HEXDIG . '{4,4})+)',
        ls32 = '(?:' . self::h16 . ':' . self::h16 . '|' . self::IPv4address . ')',
        IPv6address =
        '(?:' .
        '(?:' . self::h16 . ':){6,6}' . self::ls32 . '|' .
        '::(?:' . self::h16 . ':){5,5}' . self::ls32 . '|' .
        '(?:' . self::h16 . ')?::(?:' . self::h16 . ':){4,4}' . self::ls32 . '|' .
        '(?:(?:' . self::h16 . ':){,1}' . self::h16 . ')?::(:' . self::h16 . ':){3,3}' . self::ls32 . '|' .
        '(?:(?:' . self::h16 . ':){,2}' . self::h16 . ')?::(?:' . self::h16 . ':){2,2}' . self::ls32 . '|' .
        '(?:(?:' . self::h16 . ':){,3}' . self::h16 . ')?::' . self::h16 . ':' . self::ls32 . '|' .
        '(?:(?:' . self::h16 . ':){,4}' . self::h16 . ')?::' . self::ls32 . '|' .
        '(?:(?:' . self::h16 . ':){,5}' . self::h16 . ')?::' . self::h16 . '|' .
        '(?:(?:' . self::h16 . ':){,6}' . self::h16 . ')?::' .
        ')',
        IPvFuture = '(?:v' . ABNF::HEXDIG . '+\\.(?:' . self::unreserved . '|' . self::sub_delims . '|:)+)',
        IP_literal = '(?:\\[(?:' . self::IPv6address . '|' . self::IPvFuture . ')\\])',
        port = '(?:\\d*)',
        authority = '(?:(?:' . self::userinfo . '@)?' . self::host . '(?::' . self::port . ')?)',
        pchar = '(?:' . self::unreserved . '|' . self::pct_encoded . '|' . self::sub_delims . '|@)',
        segment_nz_nc = '(?:(?:' . self::unreserved . '|' . self::pct_encoded . '|' . self::sub_delims . '@)+)',
        segment_nz = '(?:' . self::pchar . '+)',
        segment = '(?:' . self::pchar . '*)',
        path_empty = '(?:' . self::pchar . '{0,0})',
        path_rootless = '(?:' . self::segment_nz . '(?:\\/' . self::segment . ')*)',
        path_noscheme = '(?:' . self::segment_nz_nc . '(?:\\/' . self::segment . ')*)',
        path_absolute = '(?:\\/(?:' . self::segment_nz . '(?:\\/' . self::segment . ')*)?)',
        path_abempty = '(?:(?:\\/' . self::segment . ')*)',
        path = '(?:' . self::path_abempty . '|' . self::path_absolute . '|' . self::path_noscheme . '|' . self::path_rootless . '|' . self::path_empty . ')',
        hier_part = '(?:\\/\\/' . self::authority . self::path_abempty . '|' . self::path_absolute . '|' . self::path_rootless . '|' . self::path_empty . ')',
        query = '(?:(?:' . self::pchar . '|\\/|\\?)*)',
        fragment = '(?:(?:' . self::pchar . '|\\/|\\?)*)',
        URI = '(?:' . self::scheme . ':' . self::hier_part . '(?:\\?' . self::query . ')?(?:#' . self::fragment . ')?)';
}
