<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling;

use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Service\DriverAvailability\DriverTripsRepository;
use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripCollection;
use Bookee\Domain\Scheduling\TripRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class TripRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling
 */
class TripRepositoryDoctrine implements TripRepositoryInterface, DriverTripsRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Trip $trip): void
    {
        $this->entityManager->persist($trip);
        $this->entityManager->flush();
    }

    public function tripsForRouteAndDate(DriverId $driverId, RouteId $routeId, \DateTimeImmutable $date): TripCollection
    {
        $trips = $this->entityManager
            ->getRepository(Trip::class)
            ->createQueryBuilder('t')
            ->select('t')
            ->where('t.driverId = :driver_id')
            ->andWhere('t.routeId = :route_id')
            ->andWhere('t.departsAt BETWEEN :departs_start AND :departs_end')
            ->setParameters(
                [
                    'driver_id' => $driverId,
                    'route_id' => $routeId,
                    'departs_start' => $date->format('Y-m-d 00:00:00'),
                    'departs_end' => $date->format('Y-m-d 23:59:59'),
                ]
            )
            ->getQuery()
            ->getResult()
        ;

        return new TripCollection(...$trips);
    }
}