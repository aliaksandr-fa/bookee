<?php declare(strict_types=1);

namespace Bookee\Domain\Booking;

use Bookee\Domain\Shared\DomainException;


/**
 * Class NotEnoughSeats
 *
 * @package Bookee\Domain\Booking
 */
class NotEnoughSeatsException extends DomainException
{
    public function __construct(string $message = "Not enough seats.")
    {
        parent::__construct($message);
    }
}