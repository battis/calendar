<?php


namespace Battis\Calendar\Standards;

/**
 * @link https://tools.ietf.org/html/rfc3629 RFC 3629 UTF-8
 */
interface RFC3629
{
    const
        UTF8_tail = '[\\x80-\\xBF]',
        UTF8_1 = '[\\x00-\\x7F]',
        UTF8_2 = '(?:[\\xC2-\\xDF]' . self::UTF8_tail . ')',
        UTF8_3 =
        '(?:' .
        '\\xE0[\\xA0-BF]' . self::UTF8_tail . '|' .
        '[\\xE1-\\xEC]' . self::UTF8_tail . '{2,2}|' .
        '\\xED[\\x80-\\x9F]' . self::UTF8_tail . '{2,2}|' .
        '[\\xEE-\\xEF]' . self::UTF8_tail . '{2,2}' .
        ')',
        UTF8_4 =
        '(?:' .
        '\\xF0[\\x90-\\xBF]' . self::UTF8_tail . '{2,2}|' .
        '[\\xF1-\\xF3]' . self::UTF8_tail . '{3,3}|' .
        '\\xF4[\\x80-\\x8F]' . self::UTF8_tail . '{2,2}' .
        ')',
        UTF8_char = '(?:' . self::UTF8_1 . '|' . self::UTF8_2 . '|' . self::UTF8_3 . '|' . self::UTF8_4 . ')',
        UTF8_octets = '(?:' . self::UTF8_char . '*)';
}
