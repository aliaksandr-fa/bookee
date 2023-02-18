<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling;

use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Scheduling\Driver\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class RoutesRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling
 */
class DriverRepositoryDoctrine implements DriverRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findById(DriverId $driverId): ?Driver
    {
        $driver = $this->entityManager
            ->getRepository(Driver::class)
            ->findOneBy(['id' => $driverId])
        ;

        return $driver;
    }
}