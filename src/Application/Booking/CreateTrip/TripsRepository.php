<?php declare(strict_types=1);

namespace Bookee\Application\Booking\CreateTrip;

use Bookee\Domain\Booking\Trip;


/**
 * Interface TripsRepository
 *
 * @package Bookee\Application\Booking\CreateTrip
 */
interface TripsRepository
{
    public function save(Trip $trip): void;
}