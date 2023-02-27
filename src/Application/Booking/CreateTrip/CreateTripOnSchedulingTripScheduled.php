<?php declare(strict_types=1);

namespace Bookee\Application\Booking\CreateTrip;

use Bookee\Domain\Booking\RouteId;
use Bookee\Domain\Booking\Trip;
use Bookee\Domain\Booking\TripId;
use Bookee\Domain\Scheduling\TripScheduledDomainEvent;
use Bookee\Infrastructure\Bus\Event\EventHandler;


/**
 * Class CreateTripOnSchedulingTripScheduled
 *
 * @package Bookee\Application\Booking\CreateTrip
 */
class CreateTripOnSchedulingTripScheduled implements EventHandler
{
    public function __construct(private readonly TripsRepository $trips)
    {
    }

    public function __invoke(TripScheduledDomainEvent $event): void
    {
        $this->trips->save(
            new Trip(new TripId($event->tripId), new RouteId($event->routeId), $event->departsAt, $event->seats)
        );
    }
}