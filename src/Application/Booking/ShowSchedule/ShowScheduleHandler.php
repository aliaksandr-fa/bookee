<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowSchedule;

use Bookee\Application\Booking\ShowSchedule\Route\RouteFetcher;
use Bookee\Domain\Booking\RouteId;
use Bookee\Infrastructure\Bus\Query\QueryHandler;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class ShowScheduleHandler
 *
 * @package Bookee\Application\Booking\ShowSchedule
 */
class ShowScheduleHandler implements QueryHandler
{
    public function __construct(
        private readonly RouteFetcher $routeFetcher,
        private readonly ScheduleFetcher $scheduleFetcher
    ) {}

    public function __invoke(ShowScheduleQuery $query): ?Response
    {
        $routeData = $this->routeFetcher->findRouteByRouteId($query->routeId);

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $query->date);

        $trips = $this->scheduleFetcher->findForRouteAndDate(new RouteId($query->routeId), $date);

        return new ShowScheduleResponse(
            $query->routeId,
            $routeData->name,
            $date,
            $trips
        );
    }
}