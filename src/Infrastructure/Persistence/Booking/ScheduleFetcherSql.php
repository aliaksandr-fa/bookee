<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking;

use Bookee\Application\Booking\ShowSchedule\ScheduleFetcher;
use Bookee\Domain\Booking\RouteId;
use Doctrine\DBAL\Connection;


/**
 * Class ScheduleFetcherSql
 *
 * @package Bookee\Infrastructure\Persistence\Booking
 */
class ScheduleFetcherSql implements ScheduleFetcher
{
    public function __construct(private Connection $connection) {}


    public function findForRouteAndDate(RouteId $routeId, \DateTimeImmutable $date): array
    {
        $trips = $this->connection->createQueryBuilder()
            ->from('booking_trips', 'trips')
            ->select(
                'trips.id as id',
                'trips.departs_at',
                "TO_CHAR(trips.departs_at, 'HH24:MI') as departs_at_time",
                'trips.seats',
                "split_part(trips.driver, ',', 1) as driver_name",
                "split_part(trips.driver, ',', 2) as driver_phone",
                'trips.bus'
            )
            ->andWhere('trips.route_id = :route_id')
            ->andWhere('trips.departs_at BETWEEN :departs_start AND :departs_end')
            ->setParameters([
                'route_id' => $routeId->value(),
                'departs_start' => $date->format('Y-m-d 00:00:00'),
                'departs_end' => $date->format('Y-m-d 23:59:59'),
            ])
            ->addOrderBy('trips.departs_at', 'asc')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return $trips;
    }
}