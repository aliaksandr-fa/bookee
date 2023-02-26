<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowSchedule;

use Bookee\Domain\Booking\RouteId;


/**
 * Interface ScheduleFetcher
 *
 * @package Bookee\Application\Booking\ShowSchedule
 */
interface ScheduleFetcher
{
    public function findForRouteAndDate(RouteId $routeId, \DateTimeImmutable $date): array;
}