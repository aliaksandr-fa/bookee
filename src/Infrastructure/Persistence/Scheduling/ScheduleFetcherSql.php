<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling;

use Bookee\Application\Scheduling\ShowSchedule\ScheduleFetcher;
use Bookee\Domain\Scheduling\RouteId;
use Doctrine\DBAL\Connection;


/**
 * Class ScheduleFetcherSql
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling
 */
class ScheduleFetcherSql implements ScheduleFetcher
{
    public function __construct(private Connection $connection) {}


    public function findForRouteAndDate(RouteId $routeId, \DateTimeImmutable $date): array
    {
        $trips = $this->connection->createQueryBuilder()
            ->from('scheduling_trips', 'trips')
            ->select(
                'trips.status',
                'trips.seats',
                'trips.duration',
                "TO_CHAR((trips.duration || ' second')::interval, 'HH24:MI') as duration_formatted",
                'trips.departs_at',
                "TO_CHAR(trips.departs_at, 'HH24:MI') as departs_at_time",
                "TO_CHAR((trips.departs_at + trips.duration * interval '1 second'), 'HH24:MI') as  arrives_at_time",
                'routes.name as route_name',
                'drivers.name as driver_name',
                'drivers.phone_number as driver_phone_number',
                'buses.plate_number as bus_plate_number',
            )
            ->andWhere('trips.route_id = :route_id')
            ->andWhere('trips.departs_at BETWEEN :departs_start AND :departs_end')
            ->leftJoin('trips', 'scheduling_routes', 'routes', 'trips.route_id = routes.id')
            ->leftJoin('trips', 'scheduling_drivers', 'drivers', 'trips.driver_id = drivers.id')
            ->leftJoin('trips', 'scheduling_buses', 'buses', 'trips.bus_id = buses.id')
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