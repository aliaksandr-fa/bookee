<?php

declare(strict_types=1);

namespace Bookee\Infrastructure\Bus\Query;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;


final class SymfonyMessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function ask(Query $query): ?Response
    {
        return $this->handleQuery($query);
    }
}
