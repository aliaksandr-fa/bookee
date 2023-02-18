<?php declare(strict_types=1);

namespace Bookee\Domain\Shared;

/**
 * Interface HasDomainEvents
 *
 * @package Bookee\Shared\Domain
 */
interface HasDomainEvents
{
    public function releaseEvents(): array;
}