<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\GetRoute;

use Bookee\Infrastructure\Bus\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class GetRouteQuery
 *
 * @package Bookee\Application\Navigation\GetRoute
 */
class GetRouteQuery implements Query
{
    public function __construct(
        #[Assert\Uuid]
        public string $routeId
    ) {}
}