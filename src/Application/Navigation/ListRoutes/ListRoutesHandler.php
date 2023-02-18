<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\ListRoutes;

use Bookee\Infrastructure\Bus\Query\QueryHandler;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class Handler
 *
 * @package Bookee\Application\Navigation\ListAllRoutes
 */
class ListRoutesHandler implements QueryHandler
{
    public function __construct(
        private readonly RoutesFetcher $routesFetcher
    ) {}

    public function __invoke(ListRoutesQuery $query): ?Response
    {
        return new ListRoutesResponse(
            $this->routesFetcher->listRoutes($query->offset, $query->limit)
        );
    }
}