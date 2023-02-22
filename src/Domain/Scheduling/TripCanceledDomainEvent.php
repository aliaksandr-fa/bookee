<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use Bookee\Domain\Shared\DomainEvent;


/**
 * Class TripCanceledDomainEvent
 *
 * @package Bookee\Domain\Scheduling
 */
class TripCanceledDomainEvent implements DomainEvent
{
    public function __construct(public string $tripId) {}
}