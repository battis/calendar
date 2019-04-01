<?php


namespace Battis\Calendar\Workflows;


use Battis\Calendar\Component;

interface Exporter
{
    public static function export(Component $component): string;
}
