<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Service\CreateTrip;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Service\DriverAvailability\DriverAvailabilityChecker;
use Bookee\Domain\Scheduling\Service\DriverAvailability\UnavailableDriverException;
use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripId;
use Bookee\Domain\Scheduling\TripRepositoryInterface;


/**
 * Class CreateTripService
 *
 * @package Bookee\Domain\Scheduling
 */
class CreateTripService
{
    public function __construct(
        private readonly DriverAvailabilityChecker $driverAvailability,
        private readonly TripRepositoryInterface $trips
    ) {}

    public function create(\DateTimeImmutable $forDate, Route $route, ?Driver $driver, ?Bus $bus, ?int $seats): Trip
    {
        if (null !== $driver)
        {
            $this->ensureDriverAvailability($driver, $route->id(), $forDate);
        }

        $trip = new Trip(
            TripId::next(),
            $route->id(),
            $forDate,
            $route->duration(),
            $seats
        );

        $trip->assignDriver($driver);
        $trip->assignBus($bus);

        $this->trips->save($trip);

        return $trip;
    }

    private function ensureDriverAvailability(Driver $driver, RouteId $routeId, \DateTimeImmutable $date): void
    {
        $isDriverAvailable = $this->driverAvailability->isDriverAvailable($driver, $routeId, $date);

        if (!$isDriverAvailable)
        {
            throw new UnavailableDriverException("Driver {$driver->name()} is not available for this route and time.");
        }
    }
}