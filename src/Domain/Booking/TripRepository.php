<?php declare(strict_types=1);

namespace Bookee\Domain\Booking;


/**
 * Interface TripRepository
 *
 * @package Bookee\Domain\Booking
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