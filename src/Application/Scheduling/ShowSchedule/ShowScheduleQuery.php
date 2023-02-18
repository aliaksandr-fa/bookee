<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ShowSchedule;

use Symfony\Component\Validator\Constraints as Assert;
use Bookee\Infrastructure\Bus\Query\Query;


/**
 * Class ShowScheduleQuery
 *
 * @package Bookee\Application\Scheduling\ShowSchedule
 */
class ShowScheduleQuery implements Query
{
    public function __construct(
        #[Assert\Uuid]
        public string $routeId,
        #[Assert\Date]
        public string $date
    ) {}
}