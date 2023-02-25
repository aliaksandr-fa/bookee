<?php declare(strict_types=1);

namespace Bookee\Domain\Booking;

use Bookee\Domain\Booking\Passenger\PassengerId;

/**
 * Class CheckIn
 *
 * @package Bookee\Domain\Booking
 */
class CheckIn
{
    private \DateTimeImmutable $checkedInAt;

    public function __construct(
        private readonly PassengerId $passengerId
    ) {
        $this->checkedInAt = new \DateTimeImmutable();
    }
}