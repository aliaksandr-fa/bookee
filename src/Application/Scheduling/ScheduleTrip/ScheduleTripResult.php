<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ScheduleTrip;

use Bookee\Infrastructure\Bus\Command\Response;

/**
 * Class ScheduleTripResult
 *
 * @package Bookee\Application\Scheduling\ScheduleTrip
 */
class ScheduleTripResult implements Response
{
    public function __construct(public string $tripId) {}
}