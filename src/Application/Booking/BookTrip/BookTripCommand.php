<?php declare(strict_types=1);

namespace Bookee\Application\Booking\BookTrip;

use Bookee\Infrastructure\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class BookTripCommand
 *
 * @package Bookee\Application\Booking\BookTrip
 */
class BookTripCommand  implements Command
{
    public function __construct(
        #[Assert\Uuid]
        public string $tripId,
        #[Assert\Uuid]
        public string $passengerId,
        #[Assert\PositiveOrZero]
        public int $seats
    ) {}
}