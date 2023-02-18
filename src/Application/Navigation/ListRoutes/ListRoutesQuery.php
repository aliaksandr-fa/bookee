<?php declare(strict_types=1);

namespace Bookee\Application\Navigation\ListRoutes;

use Bookee\Infrastructure\Bus\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Query
 *
 * @package Bookee\Application\Navigation\ListAllRoutes
 */
class ListRoutesQuery implements Query
{
    public function __construct(
        public ?int $offset = 0,
        public ?int $limit = null
    ) {}
}