<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\ScheduleTrip;


use Bookee\Infrastructure\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class ScheduleTripCommand
 *
 * @package Bookee\Application\Scheduling\ScheduleTrip
 */
class ScheduleTripCommand implements Command
{
    #[Assert\Uuid]
    public string $routeId;

    #[Assert\DateTime]
    public \DateTimeImmutable $departsAt;

    #[Assert\PositiveOrZero]
    public ?int $duration = null;

    #[Assert\Uuid]
    public ?string $driverId = null;

    #[Assert\Uuid]
    public ?string $busId = null;

    public bool $chooseBusAutomatically = true;

    #[Assert\PositiveOrZero]
    public ?string $seats = null;
}