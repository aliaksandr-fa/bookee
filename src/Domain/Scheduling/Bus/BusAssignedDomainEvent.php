<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Bus;

use Bookee\Domain\Shared\DomainEvent;


/**
 * Class BusAssignedDomainEvent
 *
 * @package Bookee\Domain\Scheduling\Bus
 */
class BusAssignedDomainEvent implements DomainEvent
{
    public function __construct(
        public string $tripId,
        public string $busId
    ) {}
}