<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\AddRoute;

use Bookee\Domain\Scheduling\Route;

/**
 * Class RouteRepository
 *
 * @package Bookee\Application\Scheduling\AddRoute
 */
interface RoutesRepository
{
    public function save(Route $route): void;
}