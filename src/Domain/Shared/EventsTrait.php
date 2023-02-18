<?php declare(strict_types=1);

namespace Bookee\Domain\Shared;

/**
 * Trait EventsTrait
 *
 * @package Bookee\Shared\Domain
 */
trait EventsTrait
{
    /** @var DomainEvent[] */
    private array $recordedEvents = [];

    protected function recordEvent(DomainEvent $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}