<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ScheduleTrip;

use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripId;


/**
 * Class TripRepository
 *
 * @package Bookee\Application\Scheduling\ScheduleTrip
 */
interface TripRepository
{
    /**
     * @throws TripNotFoundException
     * @param TripId $tripId
     * @return Trip
     */
    public function getById(TripId $tripId): Trip;

    public function save(Trip $trip): void;
}