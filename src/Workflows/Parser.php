<?php


namespace Battis\Calendar\Workflows;


use Battis\Calendar\Component;

interface Parser
{
    public static function parse(string $text): ?Component;
}
