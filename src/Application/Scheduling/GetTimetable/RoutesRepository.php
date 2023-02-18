<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\GetTimetable;

use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\RouteId;


/**
 * Interface RoutesRepository
 *
 * @package Bookee\Application\Scheduling\GetTimetable
 */
interface RoutesRepository
{
    public function findRoute(RouteId $routeId): ?Route;
}