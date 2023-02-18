<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\CreateRoute;

use Bookee\Infrastructure\Bus\Command\Response;

/**
 * Class CreateRouteResult
 *
 * @package Bookee\Application\Navigation\CreateRoute
 */
class CreateRouteResult implements Response
{
    public function __construct(public string $routeId) {}
}