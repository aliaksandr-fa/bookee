<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ShowSchedule;

use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\RouteRepository;
use Bookee\Infrastructure\Bus\Query\QueryHandler;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class ShowScheduleHandler
 *
 * @package Bookee\Application\Scheduling\ShowSchedule
 */
class ShowScheduleHandler implements QueryHandler
{
    public function __construct(
        private readonly RouteRepository $routes,
        private readonly ScheduleFetcher $scheduleFetcher
    ) {}

    public function __invoke(ShowScheduleQuery $query): ?Response
    {
        $routeId = new RouteId($query->routeId);

        $route   = $this->routes->getById($routeId);
        $date    = \DateTimeImmutable::createFromFormat('Y-m-d', $query->date);

        $trips = $this->scheduleFetcher->findForRouteAndDate($routeId, $date);

        return new ShowScheduleResponse(
            $route->id()->value(),
            $route->name(),
            $date,
            $trips
        );
    }
}