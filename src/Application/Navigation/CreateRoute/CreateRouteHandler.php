<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateRoute;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RouteId;
use Bookee\Domain\Navigation\RoutesRepository;
use Bookee\Domain\Navigation\RouteStop;
use Bookee\Domain\Navigation\RouteStopCollection;
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
        $stops   = new RouteStopCollection();

        foreach ($command->stops as $index => $stop)
        {
            $stops->add(new RouteStop(new StopId($stop['id']), (int) $index, $stop['eta']));
        }

        $route = Route::create($routeId, $command->routeNumber, $command->routeName, $stops);

        $this->routesRepository->save($route);

        return new CreateRouteResult($routeId->value());
    }
}