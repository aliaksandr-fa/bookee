<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\CreateTrip;

use Bookee\Infrastructure\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CreateTripCommand
 *
 * @package Bookee\Application\Scheduling\CreateTrip
 */
class CreateTripCommand implements Command
{
    #[Assert\Uuid]
    public string $routeId;

    #[Assert\Date]
    public string $departureDate;

    #[Assert\Time]
    public string $departureTime;

    #[Assert\PositiveOrZero]
    public ?int $duration = null;

    #[Assert\Uuid]
    public ?string $driverId = null;

    #[Assert\Uuid]
    public ?string $busId = null;

    public bool $chooseBusAutomatically = true;

    #[Assert\PositiveOrZero]
    public ?int $seats = null;

    public function getDepartureDateTime(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "{$this->departureDate} {$this->departureTime}");
    }
}