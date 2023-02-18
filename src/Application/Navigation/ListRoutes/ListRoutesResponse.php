<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\ListRoutes;

use Bookee\Infrastructure\Bus\Query\Response;

/**
 * Class Response
 *
 * @package Bookee\Application\Navigation\ListRoutes
 */
class ListRoutesResponse implements Response
{
    public function __construct(public array $routes) {}
}