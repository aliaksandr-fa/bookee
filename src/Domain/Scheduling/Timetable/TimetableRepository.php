<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Timetable;

use Bookee\Domain\Scheduling\RouteId;


/**
 * Interface TimetableRepository
 *
 * @package Bookee\Domain\Scheduling\Timetable
 */
interface TimetableRepository
{
    public function forRouteAndDay(RouteId $routeId, CruisingDay $day): ?Timetable;
}