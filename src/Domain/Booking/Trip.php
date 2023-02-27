<?php declare(strict_types=1);

namespace Bookee\Domain\Booking;

use Bookee\Domain\Booking\Bus\BusPlateNumber;
use Bookee\Domain\Booking\Driver\Driver;
use Bookee\Domain\Booking\Passenger\PassengerId;
use Doctrine\Common\Collections\Collection;


/**
 * Class Trip
 *
 * @package Bookee\Domain\Booking
 */
class Trip
{
    private BookingCollection|Collection $bookings;

    public function __construct(
        private TripId $id,
        private RouteId $routeId,
        private \DateTimeImmutable $departsAt,
        private int $seats,
        private ?Driver $driver = null,
        private ?BusPlateNumber $bus = null
    ) {
        $this->bookings = new BookingCollection();
    }

    public function book(PassengerId $forPassenger, int $seats, \DateTimeImmutable $bookedAt): void
    {

        $this->ensureTripCanBeBooked($forPassenger, $seats);

        $this->bookings[] = new Booking(
            BookingId::next(),
            $this,
            $seats,
            $forPassenger,
            $bookedAt
        );
    }

    private function ensureTripCanBeBooked(PassengerId $forPassenger, int $seats): void
    {
        if ($seats <= 0)
        {
            throw new \InvalidArgumentException("Cannot book negative or zero seats.");
        }

        if (!$this->isEnoughSeats($seats))
        {
            throw new NotEnoughSeatsException();
        }

        if ($this->isBookedByPassenger($forPassenger))
        {
            throw new TripAlreadyBookedException("This passenger has already booked this trip.");
        }
    }

    private function isEnoughSeats(int $seatsRequested): bool
    {
        return $this->seatsAvailable() >= $seatsRequested;
    }

    public function seats(): int
    {
        return $this->seats;
    }

    public function seatsAvailable(): int
    {
        $booked = $this->bookings->reduce(fn (int $carry, Booking $booking) => $carry += $booking->seats(), 0);

        return $this->seats - $booked;
    }

    public function isBookedByPassenger(PassengerId $passengerId): bool
    {
        return $this->bookingForPassenger($passengerId) !== null;
    }

    public function bookingForPassenger(PassengerId $passengerId): ?Booking
    {
        return $this->bookings->findFirst(fn (int $index, Booking $booking) => $booking->isForPassenger($passengerId));
    }

    public function id(): TripId
    {
        return $this->id;
    }

    public function departsAt(): \DateTimeImmutable
    {
        return $this->departsAt;
    }

    public function bookings(): BookingCollection
    {
        return $this->bookings;
    }
}