<?php declare(strict_types=1);

namespace Bookee\Domain\Booking;

use Bookee\Domain\Booking\Passenger\PassengerId;


/**
 * Class Booking
 *
 * @package Bookee\Domain\Booking
 */
class Booking
{
    public function __construct(
        private BookingId $id,
        private Trip $trip,
        private int $seats,
        private PassengerId $passengerId,
        private \DateTimeImmutable $bookedAt
    ) {}

    public function isForPassenger(PassengerId $passengerId): bool
    {
        return $this->passengerId->equals($passengerId);
    }

    public function id(): BookingId
    {
        return $this->id;
    }

    public function seats(): int
    {
        return $this->seats;
    }
}