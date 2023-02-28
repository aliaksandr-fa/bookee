<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowBookedTrips;


/**
 * Class BookedTrip
 *
 * @package Bookee\Application\Booking\ShowBookedTrips
 */
class BookedTrip
{
    public function __construct(
        public string $tripId,
        public string $bookingId,
        public int $seats,
        public string $routeName,
        public int $routeNumber,
        public string $passenger,
        public \DateTimeImmutable $departsAt,
        public \DateTimeImmutable $bookedAt,
    ) {}

    public static function fromArray(array $data): BookedTrip
    {
        return new self(
            $data['trip_id'],
            $data['booking_id'],
            $data['booking_seats'],
            $data['route_name'],
            intval($data['route_number']),
            "{$data['passenger_name']}, {$data['passenger_phone']}",
            (new \DateTimeImmutable())->setTimestamp((int) $data['departs_at']),
            (new \DateTimeImmutable())->setTimestamp((int) $data['booked_at'])
        );
    }
}