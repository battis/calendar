<?php

namespace Battis\Calendar\iCalendar\RFC5545;

define('SPACE', chr(0x20));
define('HTAB', chr(0x09));
define('WSP', SPACE . HTAB);

define('CR', chr(0x0D));
define('LF', chr(0x0A));
define('CRLF', CR . LF);

define('DQUOTE', chr(0x22));
define('DIGIT', '0-9');
define('ALPHA', 'a-zA-Z');
define('CTL', '[' . chr(0x00) . '-' . chr(0x08) . chr(0x0A) . '-' . chr(0x1F) . chr(0x7F) . ']');
define('NON_US_ASCII', chr(0x80) . '-' . chr(0xF8));

define('SAFE_CHAR', WSP . chr(0x21) . chr(0x23) . '-' . chr(0x2B) . chr(0x2D) . '-' . chr(0x39) . chr(0x3C) . '-' . chr(0x7D) . NON_US_ASCII);
define('QSAFE_CHAR', WSP . chr(0x21) . chr(0x23) . '-' . chr(0x7E) . NON_US_ASCII);
define('VALUE_CHAR', WSP . chr(0x21) . '-' . chr(0x7E) . NON_US_ASCII);

define('QUOTED_STRING', DQUOTE . '[' . QSAFE_CHAR . ']*' . DQUOTE);
define('VALUE', '[' . VALUE_CHAR . ']*');

define('IANA_TOKEN', '[' . ALPHA . DIGIT . '\-]+');
define('VENDOR_ID', '[' . ALPHA . DIGIT . ']{3,3}');
define('X_NAME', 'X-(' . VENDOR_ID . '-)?[' . ALPHA . DIGIT . '\-]+');
define('NAME', '((' . IANA_TOKEN . ')|(' . X_NAME . '))');

define('PARAMTEXT', '[' . SAFE_CHAR . ']*');
define('PARAM_VALUE', '(' . PARAMTEXT . '|' . QUOTED_STRING . ')');

define('PARAM_NAME', '(' . IANA_TOKEN . '|' . X_NAME . ')');
define('PARAM', PARAM_NAME . '=' . PARAM_VALUE . '(,' . PARAM_VALUE . ')*');
define('PARAMETER_NAME', 1);
define('PARAMETER_VALUE', 3);

define('CONTENTLINE', NAME . '(;(' . PARAM .'))*:(' . VALUE . ')');
define('CONTENTLINE_NAME', 1);
define('CONTENTLINE_VALUE', 12);

define('REGEX_MATCH', 0);
define('REGEX_OFFSET', 1);

/**
	* Content Line
	*
	* {@link https://tools.ietf.org/rfcmarkup/5545#section-3.1 RFC 5545 &sect;3.1}
	*
	* ```RFC
	*    The iCalendar object is organized into individual lines of text,
	*    called content lines.  Content lines are delimited by a line break,
	*    which is a CRLF sequence (CR character followed by LF character).
	*
	*    Lines of text SHOULD NOT be longer than 75 octets, excluding the line
	*    break.  Long content lines SHOULD be split into a multiple line
	*   representations using a line "folding" technique.  That is, a long
	*    line can be split between any two characters by inserting a CRLF
	*    immediately followed by a single linear white-space character (i.e.,
	*    SPACE or HTAB).  Any sequence of CRLF followed immediately by a
	*    single linear white-space character is ignored (i.e., removed) when
	*    processing the content type.
	*
	*    For example, the line:
	*
	*      DESCRIPTION:This is a long description that exists on a long line.
	*
	*    Can be represented as:
	*
	*      DESCRIPTION:This is a lo
	*       ng description
	*        that exists on a long line.
	*
	*    The process of moving from this folded multiple-line representation
	*    to its single-line representation is called "unfolding".  Unfolding
	*    is accomplished by removing the CRLF and the linear white-space
	*    character that immediately follows.
	*
	* 	 When parsing a content line, folded lines MUST first be unfolded
	*    according to the unfolding procedure described above.
	*
	*       Note: It is possible for very simple implementations to generate
	*       improperly folded lines in the middle of a UTF-8 multi-octet
	*       sequence.  For this reason, implementations need to unfold lines
	*       in such a way to properly restore the original sequence.
	*
	*    The content information associated with an iCalendar object is
	*    formatted using a syntax similar to that defined by [RFC2425].  That
	*    is, the content information consists of CRLF-separated content lines.
	* ```
	*/
interface ContentLine {}
