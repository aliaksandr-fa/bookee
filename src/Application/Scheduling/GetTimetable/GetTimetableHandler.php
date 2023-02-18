<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\GetTimetable;

use Bookee\Domain\Scheduling\RouteId;
use Bookee\Infrastructure\Bus\Query\QueryHandler;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class GetTimetableHandler
 *
 * @package Bookee\Application\Scheduling\GetTimetable
 */
class GetTimetableHandler implements QueryHandler
{
    public function __construct(
        private TimetableFetcher $timetableFetcher,
        private RoutesRepository $routesRepository
    ) {}

    public function __invoke(GetTimetableQuery $query): ?Response
    {
        $routeId = new RouteId($query->routeId);

        // @todo: handle route not found case

        return new GetTimetableResponse(
            $this->routesRepository->findRoute($routeId),
            $this->timetableFetcher->findForRoute($routeId)
        );
    }
}