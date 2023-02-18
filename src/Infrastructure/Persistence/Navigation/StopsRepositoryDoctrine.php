<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Navigation;

use Bookee\Domain\Navigation\Stop;
use Bookee\Domain\Navigation\StopId;
use Bookee\Domain\Navigation\StopNotFoundException;
use Bookee\Domain\Navigation\StopsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


/**
 * Class StopsRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Navigation
 */
class StopsRepositoryDoctrine implements StopsRepository
{
    private EntityRepository $stops;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->stops = $this->entityManager->getRepository(Stop::class);
    }

    public function get(StopId $id): Stop
    {
        $stop = $this->stops->find($id);

        if (null === $stop) {
            throw new StopNotFoundException();
        }

        return $stop;
    }

    public function save(Stop $stop): void
    {
        $this->entityManager->persist($stop);
        $this->entityManager->flush();
    }
}