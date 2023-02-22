<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;


use Bookee\Domain\Shared\DomainException;

/**
 * Class TripWithoutBusException
 *
 * @package Bookee\Domain\Scheduling
 */
class TripWithoutBusException extends DomainException
{
    public function __construct(string $message = "Trip can't be without a bus.")
    {
        parent::__construct($message);
    }
}