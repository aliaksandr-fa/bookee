<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowBookedTrips;

use Bookee\Domain\Booking\Passenger\PassengerId;


/**
 * Interface PassengerTripsFetcher
 *
 * @package Bookee\Application\Booking\ShowBookedTrips
 */
interface PassengerTripsFetcher
{
    public function findBookedTrips(string $passengerId): array;
}