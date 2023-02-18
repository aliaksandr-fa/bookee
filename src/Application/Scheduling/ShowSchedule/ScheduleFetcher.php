<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ShowSchedule;

use Bookee\Domain\Scheduling\RouteId;


/**
 * Interface ScheduleFetcher
 *
 * @package Bookee\Application\Scheduling\ShowSchedule
 */
interface ScheduleFetcher
{
    public function findForRouteAndDate(RouteId $routeId, \DateTimeImmutable $date): array;
}