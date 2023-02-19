<?php declare(strict_types=1);

namespace Bookee\Domain\Navigation;

use Bookee\Domain\Shared\DomainEvent;


/**
 * Class RouteCreatedDomainEvent
 *
 * @package Bookee\Domain\Navigation
 */
class RouteCreatedDomainEvent implements DomainEvent
{
    public function __construct(
        public string $routeId,
        public int $number,
        public string $name,
        public array $stops,
        public ?int $duration = null
    ) {}
}