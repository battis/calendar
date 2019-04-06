<?php

use Battis\Calendar\Workflows\iCalendar;
use kigkonsult\iCalcreator\vcalendar;

require_once __DIR__ . '/../vendor/autoload.php';

define('INPUT_FILE', __DIR__ . '/ical.ics');
define('OUTPUT_DIR', __DIR__ . '/output');

$BENCHMARKS = [];

function benchmark(string $caption, callable $callback, $param = null, $verbose = false)
{
    global $BENCHMARKS;
    $result = null;
    if ($verbose) {
        echo "$caption: ";
    }
    try {
        $start = microtime(true);
        $result = $callback($caption, $param);
        $time = microtime(true) - $start;
        if ($verbose) {
            echo "$time sec";
        }
        $BENCHMARKS[$caption][] = $time;
    } catch (Exception $e) {
        if ($verbose) {
            echo $e->getMessage();
        }
    }
    if ($verbose) {
        echo PHP_EOL;
    }
    return $result;
}

function stdDev(array $values): float
{
    $n = count($values);
    $variance = 0;
    $average = array_sum($values) / $n;
    foreach ($values as $e) {
        $variance += pow($e - $average, 2);
    }
    return sqrt($variance / $n);
}

for ($i = 0; $i < $argv[1]; $i++) {
    $c = benchmark(
        'iCalCreator parse',
        function () {
            $c = new vcalendar();
            $c->parse(file_get_contents(INPUT_FILE));
            return $c;
        }
    );

    benchmark(
        'iCalCreator export',
        function (string $caption, Vcalendar $c) {
            file_put_contents(OUTPUT_DIR . "/$caption.ics", $c->createCalendar());
        },
        $c
    );

    benchmark(
        'iCalCreator dump',
        function ($caption, $c) {
            file_put_contents(OUTPUT_DIR . "/$caption.txt", var_export($c, true));
        },
        $c
    );

    unset($c);

    $c = benchmark(
        'battis parse',
        function () {
            return iCalendar::parseFile(INPUT_FILE);
        }
    );

    benchmark(
        'battis export',
        function ($caption, $c) {
            iCalendar::exportToFile($c, OUTPUT_DIR . "/$caption.ics");
        },
        $c
    );

    benchmark(
        'battis dump',
        function ($caption, $c) {
            file_put_contents(OUTPUT_DIR . "/$caption.txt", var_export($c, true));
        },
        $c
    );

    $csv = [];
    foreach ($BENCHMARKS as $caption => $times) {
        echo "$caption: ";
        $csv[0][] = $caption;
        $total = 0;
        foreach ($times as $i => $time) {
            $total += $time;
            $csv[$i + 1][] = $time;
        }
        echo 'avg ' . ($total / count($times)) . 'sec (' .
            count($times) . ' runs, ' .
            'max ' . max($times) . 'sec, ' .
            'min ' . min($times) . 'sec, ' .
            'stddev ' . stdDev($times) . 'sec' .
            ')' . PHP_EOL;
    }
    $f = fopen(OUTPUT_DIR . '/benchmark_data.csv', 'w');
    foreach ($csv as $row) {
        fputcsv($f, $row);
    }
    fclose($f);

    for ($j = 0; $j < 75; $j++) {
        echo '-';
    }
    echo PHP_EOL;
}

