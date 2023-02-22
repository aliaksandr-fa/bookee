<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Shared\DomainEvent;


/**
 * Class TripScheduledDomainEvent
 *
 * @package Bookee\Domain\Scheduling
 */
class TripScheduledDomainEvent implements DomainEvent
{
    public function __construct(public string $tripId) {}
}