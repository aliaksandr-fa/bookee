<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateRoute;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RouteId;
use Bookee\Domain\Navigation\RoutesRepository;
use Bookee\Domain\Navigation\StopId;
use Bookee\Infrastructure\Bus\Command\CommandHandler;
use Bookee\Infrastructure\Bus\Command\Response;


/**
 * Class CreateRouteHandler
 *
 * @package Bookee\Application\Navigation\CreateRoute
 */
class CreateRouteHandler implements CommandHandler
{
    public function __construct(private readonly RoutesRepository $routesRepository) {}

    public function __invoke(CreateRouteCommand $command): ?Response
    {
        $routeId = RouteId::next();

        $route = new Route($routeId, $command->routeNumber, $command->routeName);

        foreach ($command->stops as $stop)
        {
            $route->attachStop(new StopId($stop['id']), $stop['eta']);
        }

        $this->routesRepository->save($route);

        return new CreateRouteResult($routeId->value());
    }
}