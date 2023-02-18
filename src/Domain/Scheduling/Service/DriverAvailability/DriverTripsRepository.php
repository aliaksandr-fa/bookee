<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Service\DriverAvailability;

use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\TripCollection;


/**
 * Interface DriverTripsRepository
 *
 * @package Bookee\Domain\Scheduling\Service\DriverAvailability
 */
interface DriverTripsRepository
{
    public function tripsForRouteAndDate(DriverId $driverId, RouteId $routeId, \DateTimeImmutable $date): TripCollection;
}