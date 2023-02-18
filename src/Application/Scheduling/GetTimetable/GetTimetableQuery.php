<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\GetTimetable;

use Symfony\Component\Validator\Constraints as Assert;
use Bookee\Infrastructure\Bus\Query\Query;


/**
 * Class GetTimetableQuery
 *
 * @package Bookee\Application\Scheduling\GetTimetable
 */
class GetTimetableQuery implements Query
{
    public function __construct(
        #[Assert\Uuid]
        public string $routeId
    ) {}
}