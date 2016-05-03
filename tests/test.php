<?php
	
require_once 'common.inc.php';

$path = __DIR__ . '/basic.ics';
$cal = Battis\Calendar\iCalendar\RFC5545\Components\Calendar::parse($path);
$parsedPath = "$path-parsed.html";
$handle = fopen($parsedPath, 'w');
fwrite($handle, '<pre>' . var_export($cal, true) . '</pre>');
fclose($handle);
echo "$parsedPath" . PHP_EOL;