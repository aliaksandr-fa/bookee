<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking;

use Bookee\Application\Booking\ShowBookedTrips\BookedTrip;
use Bookee\Application\Booking\ShowBookedTrips\PassengerTripsFetcher;
use Doctrine\DBAL\Connection;


/**
 * Class BookedTripFetcherSql
 *
 * @package Bookee\Infrastructure\Persistence\Booking
 */
class BookedTripFetcherSql implements PassengerTripsFetcher
{
    public function __construct(private Connection $connection) {}

    /**
     * @param string $passengerId
     * @return BookedTrip[]
     * @throws \Doctrine\DBAL\Exception
     */
    public function findBookedTrips(string $passengerId): array
    {
        $data = $this->connection->createQueryBuilder()
            ->from('booking_trips', 'trips')
            ->select(
                'trips.id as trip_id',
                'bookings.id as booking_id',
                'bookings.seats as booking_seats',
                'passengers.name_first_name as passenger_name',
                'passengers.phone as passenger_phone',
                'trips.route_id as route_id',
                'trips.route_id as route_name',
                'trips.route_id as route_number',
                "date_part('epoch', trips.departs_at) as departs_at",
                "date_part('epoch', bookings.booked_at) as booked_at"
            )
            ->leftJoin('trips', 'booking_bookings', 'bookings', 'trips.id = bookings.trip_id')
            ->leftJoin('bookings', 'booking_passengers', 'passengers', 'bookings.passenger_id = passengers.id')
            ->andWhere('bookings.passenger_id = :passenger_id')
            ->setParameters([
                'passenger_id' => $passengerId
            ])
            ->addOrderBy('trips.departs_at', 'asc')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return array_map(fn ($row) => BookedTrip::fromArray($row), $data);
    }
}