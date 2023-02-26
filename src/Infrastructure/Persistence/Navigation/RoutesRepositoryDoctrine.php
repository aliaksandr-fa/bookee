<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Navigation;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RouteId;
use Bookee\Domain\Navigation\RoutesRepository;
use Bookee\Application\Navigation\GetRoute\RoutesRepository as GetRouteRoutesRepository;
use Bookee\Infrastructure\Bus\Event\EventBus;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class RoutesRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Navigation
 */
class RoutesRepositoryDoctrine implements RoutesRepository, GetRouteRoutesRepository
{
    public function __construct(private EntityManagerInterface $entityManager, private EventBus $events)
    {
    }

    public function all(): array
    {
        return $this->entityManager->getRepository(Route::class)->findAll();
    }

    public function save(Route $route): void
    {
        $this->entityManager->persist($route);
        $this->entityManager->flush();

        $this->events->publish(...$route->releaseEvents());
    }

    public function findById(RouteId $routeId): ?Route
    {
        return $this->entityManager->getRepository(Route::class)->findOneBy([
            'id' => $routeId
        ]);
    }
}