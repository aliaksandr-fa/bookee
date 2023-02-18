<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Scheduling;

use Bookee\Application\Scheduling\GetTimetable\RoutesRepository as SchedulingRoutesRepository;
use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\RouteNotFoundException;
use Bookee\Domain\Scheduling\RouteRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RoutesRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Scheduling
 */
class RoutesRepositoryDoctrine implements SchedulingRoutesRepository, RouteRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findRoute(RouteId $routeId): ?Route
    {
        $route = $this->entityManager
            ->getRepository(Route::class)
            ->findOneBy(['id' => $routeId])
        ;

        return $route;
    }

    /**
     * @throws RouteNotFoundException
     * @param RouteId $routeId
     * @return Route
     */
    public function getById(RouteId $routeId): Route
    {
        $route = $this->findRoute($routeId);

        if (!$route)
        {
            throw new RouteNotFoundException("Route $routeId not found");
        }

        return $route;
    }
}