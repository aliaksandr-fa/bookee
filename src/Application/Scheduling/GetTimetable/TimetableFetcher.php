<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\GetTimetable;

use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Timetable\TimetableCollection;


/**
 * Interface TimetableFetcher
 *
 * @package Bookee\Application\Scheduling\GetTimetable
 */
interface TimetableFetcher
{
    public function findForRoute(RouteId $id): TimetableCollection;
}