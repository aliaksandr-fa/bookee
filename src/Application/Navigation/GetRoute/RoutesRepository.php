<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\GetRoute;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Navigation\RouteId;


/**
 * Interface RoutesRepository
 *
 * @package Bookee\Application\Navigation\GetRoute
 */
interface RoutesRepository
{
    public function findById(RouteId $routeId): ?Route;
}