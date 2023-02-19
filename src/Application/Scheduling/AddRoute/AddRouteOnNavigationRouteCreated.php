<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\AddRoute;

use Bookee\Domain\Navigation\RouteCreatedDomainEvent;
use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Infrastructure\Bus\Event\EventHandler;


/**
 * Class AddRouteOnNavigationRouteCreated
 *
 * @package Bookee\Application\Scheduling\AddRoute
 */
class AddRouteOnNavigationRouteCreated implements EventHandler
{
    public function __construct(private readonly RoutesRepository $routes)
    {
    }

    public function __invoke(RouteCreatedDomainEvent $event): void
    {
        $this->routes->save(
            new Route(new RouteId($event->routeId), $event->name, $event->duration ?? 0)
        );
    }
}