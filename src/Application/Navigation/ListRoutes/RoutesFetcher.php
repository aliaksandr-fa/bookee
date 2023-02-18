<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\ListRoutes;


/**
 * Interface RoutesFetcher
 *
 * @package Bookee\Application\Navigation\ListRoutes
 */
interface RoutesFetcher
{
    public function listRoutes(int $offset = 0, ?int $limit = null): array;
}