<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Bus\Query;


/**
 * Interface QueryBus
 *
 * @package Bookee\Infrastructure\Bus
 */
interface QueryBus
{
    public function ask(Query $query): ?Response;
}