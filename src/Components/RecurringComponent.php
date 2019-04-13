<?php


namespace Battis\Calendar\Components;


use Battis\Calendar\Component;
use Battis\Calendar\Properties\Component\DateTime\DateTimeStart;
use Battis\Calendar\Values\RecurrenceRule;

abstract class RecurringComponent extends Component
{
    /**
     * @return RecurringComponent[]
     */
    public function getRecurrenceSet(): array
    {
        $recurrenceSet = [];
        if (($rrule = $this->getProperty(RecurrenceRule::class)) !== null) {
            if (($dtstart = $this->getProperty(DateTimeStart::class)) !== null) {

            }
        }
        return $recurrenceSet;
    }
}
