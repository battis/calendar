<?php


namespace Battis\Calendar\Standards;

/**
 * @link https://tools.ietf.org/html/rfc3629 RFC 3629 UTF-8
 */
interface RFC3629
{
    const
        _UTF8_TAIL = '[\\x80-\\xBF]',
        UTF8_1 = '[\\x00-\\x7F]',
        UTF8_2 = '(?:[\\xC2-\\xDF]' . self::_UTF8_TAIL . ')',
        UTF8_3 =
        '(?:' .
        '\\xE0[\\xA0-BF]' . self::_UTF8_TAIL . '|' .
        '[\\xE1-\\xEC]' . self::_UTF8_TAIL . '{2,2}|' .
        '\\xED[\\x80-\\x9F]' . self::_UTF8_TAIL . '{2,2}|' .
        '[\\xEE-\\xEF]' . self::_UTF8_TAIL . '{2,2}' .
        ')',
        UTF8_4 =
        '(?:' .
        '\\xF0[\\x90-\\xBF]' . self::_UTF8_TAIL . '{2,2}|' .
        '[\\xF1-\\xF3]' . self::_UTF8_TAIL . '{3,3}|' .
        '\\xF4[\\x80-\\x8F]' . self::_UTF8_TAIL . '{2,2}' .
        ')',
        UTF8_CHAR = '(?:' . self::UTF8_1 . '|' . self::UTF8_2 . '|' . self::UTF8_3 . '|' . self::UTF8_4 . ')',
        UTF8_OCTETS = '(?:' . self::UTF8_CHAR . '*)';
}
