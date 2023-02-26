<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\GetRoute;

use Bookee\Domain\Navigation\RouteId;
use Bookee\Infrastructure\Bus\Query\QueryHandler;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class GetRouteHandler
 *
 * @package Bookee\Application\Navigation\GetRoute
 */
class GetRouteHandler implements QueryHandler
{
    public function __construct(private readonly RoutesRepository $routes) {}

    public function __invoke(GetRouteQuery $query): ?Response
    {
        $route = $this->routes->findById(new RouteId($query->routeId));

        if ($route === null)
        {
            throw new RouteNotFoundException("Route {$query->routeId} not found.");
        }

        return new GetRouteResponse(
            $route->id()->value(),
            $route->number(),
            $route->name(),
            $route->duration()
        );
    }
}