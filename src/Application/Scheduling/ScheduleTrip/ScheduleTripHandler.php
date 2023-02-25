<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ScheduleTrip;

use Bookee\Domain\Scheduling\TripId;
use Bookee\Infrastructure\Bus\Command\CommandHandler;
use Bookee\Infrastructure\Bus\Command\Response;
use Bookee\Infrastructure\Bus\Event\EventBus;


/**
 * Class ScheduleTripHandler
 *
 * @package Bookee\Application\Scheduling\ScheduleTrip
 */
class ScheduleTripHandler implements CommandHandler
{
    public function __construct(
        private readonly TripRepository $trips,
        private readonly EventBus $events
    ){}

    public function __invoke(ScheduleTripCommand $command): ?Response
    {
        $trip  = $this->trips->getById(new TripId($command->tripId));

        $trip->schedule();

        $this->trips->save($trip);

        $this->events->publish(...$trip->releaseEvents());

        return null;
    }
}