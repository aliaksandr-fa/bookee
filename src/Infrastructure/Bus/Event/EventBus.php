<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Bus\Event;

use Bookee\Domain\Shared\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
