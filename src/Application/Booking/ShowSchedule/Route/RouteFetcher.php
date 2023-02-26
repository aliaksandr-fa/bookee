<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowSchedule\Route;

use Bookee\Domain\Navigation\RouteNotFoundException;


/**
 * Interface RouteFetcher
 *
 * @package Bookee\Application\Booking\ShowSchedule
 */
interface RouteFetcher
{
    /**
     * @throws RouteNotFoundException
     * @param string $routeId
     * @return RouteData|null
     */
    public function findRouteByRouteId(string $routeId): ?RouteData;
}