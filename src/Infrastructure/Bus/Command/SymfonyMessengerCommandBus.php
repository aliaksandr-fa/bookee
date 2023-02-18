<?php
declare(strict_types=1);

namespace Bookee\Infrastructure\Bus\Command;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;


final class SymfonyMessengerCommandBus implements CommandBus
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function run(Command $command): ?Response
    {
        $stamp = $this->bus->dispatch($command)->last(HandledStamp::class);

        return $stamp?->getResult();
    }
}
