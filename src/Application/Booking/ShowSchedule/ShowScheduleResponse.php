<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowSchedule;

use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class ShowScheduleResponse
 *
 * @package Bookee\Application\Booking\ShowSchedule
 */
class ShowScheduleResponse  implements Response
{
    public function __construct(
        public string $routeId,
        public string $routeName,
        public \DateTimeImmutable $date,
        public array $trips
    ) {}

    public function hasTrips(): bool
    {
        return count($this->trips) > 0;
    }
}