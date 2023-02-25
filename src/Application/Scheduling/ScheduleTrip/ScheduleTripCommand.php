<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ScheduleTrip;

use Bookee\Infrastructure\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class ScheduleTripCommand
 *
 * @package Bookee\Application\Scheduling\CreateTrip
 */
class ScheduleTripCommand implements Command
{
    #[Assert\Uuid]
    public string $tripId;
}