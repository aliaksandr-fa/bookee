<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Service\DriverAvailability;

use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripCollection;


/**
 * Class DriverAvailabilityChecker
 *
 * @package Bookee\Domain\Scheduling\Service
 */
class DriverAvailabilityChecker
{
    public function __construct(private readonly DriverTripsRepository $driverTripsRepository) {}

    public function isDriverAvailable(Driver $driver, RouteId $routeId, \DateTimeImmutable $date): bool
    {
        $trips = $this->driverTripsRepository->tripsForRouteAndDate($driver->id(), $routeId, $date);

        $this->sortTrips($trips);

        $unavailabilityIntervals = $this->getUnavailabilityIntervals($trips);

        $timestamp = $date->getTimestamp();

        foreach ($unavailabilityIntervals as $interval)
        {
            if ($timestamp >= $interval[0] || $timestamp <= $interval[1])
            {
                return false;
            }
        }

        return true;
    }

    private function getUnavailabilityIntervals(TripCollection $trips): array
    {
        $intervals = [];

        /** @var Trip $trip */
        foreach ($trips as $trip)
        {
            $intervals[] = [
                $trip->departsAt()->getTimestamp(),
                $trip->duration() * 2 // including time to get back to the route start
            ];
        }

        return $intervals;
    }

    private function sortTrips(TripCollection $trips): void
    {
        $trips->uasort(function (Trip $a, Trip $b) {

            if ($a->departsAt()->equals($b->departsAt()))
            {
                return 0;
            }

            return $a->departsAt()->biggerThan($b->departsAt()) ? 1 : -1;
        });
    }

}