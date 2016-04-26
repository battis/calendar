<?php

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
define('X_NAME', 'X-(' . VENDOR_ID . '-)?' . IANA_TOKEN);
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