<?php /** @noinspection PhpIncompatibleReturnTypeInspection */


namespace Battis\Calendar;


use Battis\Calendar\Components\Event;

class Calendar extends Component
{
    const VERSION = '0.1-dev';

    /**
     * @return Event[]
     */
    public function getAllEvents(): array
    {
        return $this->getAllComponents(Event::class);
    }
}
