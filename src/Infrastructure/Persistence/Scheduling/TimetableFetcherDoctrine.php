<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling;

use Bookee\Application\Scheduling\GetTimetable\TimetableFetcher;
use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Timetable\Timetable;
use Bookee\Domain\Scheduling\Timetable\TimetableCollection;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class TimetableFetcherDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling
 */
class TimetableFetcherDoctrine implements TimetableFetcher
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Route $route): void
    {
        $this->entityManager->persist($route);
        $this->entityManager->flush();
    }

    public function findForRoute(RouteId $id): TimetableCollection
    {

        $timetables = $this->entityManager
            ->getRepository(Timetable::class)
            ->findBy(['routeId' => $id])
        ;

        return new TimetableCollection(...$timetables);
    }
}