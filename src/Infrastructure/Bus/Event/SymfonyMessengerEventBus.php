<?php
declare(strict_types=1);

namespace Bookee\Infrastructure\Bus\Event;

use Bookee\Domain\Shared\DomainEvent;
use Symfony\Component\Messenger\MessageBusInterface;


final class SymfonyMessengerEventBus implements EventBus
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->bus = $eventBus;
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event)
        {
            $this->bus->dispatch($event);
        }
    }
}
