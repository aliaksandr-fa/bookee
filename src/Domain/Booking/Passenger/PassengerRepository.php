<?php declare(strict_types=1);

namespace Bookee\Domain\Booking\Passenger;


/**
 * Interface PassengerRepository
 *
 * @package Bookee\Domain\Booking\Passenger
 */
interface PassengerRepository
{
    /**
     * @throws PassengerNotFoundException
     * @param PassengerId $passengerId
     * @return Passenger
     */
    public function getById(PassengerId $passengerId): Passenger;

    public function save(Passenger $passenger): void;
}