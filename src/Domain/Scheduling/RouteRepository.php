<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;


/**
 * Interface RouteRepository
 *
 * @package Bookee\Domain\Scheduling
 */
interface RouteRepository
{
    /**
     * @param RouteId $routeId
     * @return Route
     *
     * @throws RouteNotFoundException
     */
    public function getById(RouteId $routeId): Route;
}