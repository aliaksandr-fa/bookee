<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Bus\BusId;
use Bookee\Domain\Scheduling\Bus\BusRepository;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Driver\DriverId;
use Bookee\Domain\Scheduling\Route;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class RoutesRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling
 */
class BusRepositoryDoctrine implements BusRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }


    public function getDrivableByDriver(DriverId $driverId): ?Bus
    {
        /** @var Driver $driver */
        $driver = $this->entityManager
            ->getRepository(Driver::class)
            ->findOneBy(['id' => $driverId])
        ;

        if ($driver && $driver->hasDrivableBuses())
        {
            return $this->findById($driver->buses()[0]);
        }

        return null;
    }

    public function findById(BusId $busId): ?Bus
    {
        $bus = $this->entityManager
            ->getRepository(Bus::class)
            ->findOneBy(['id' => $busId])
        ;

        return $bus;
    }
}