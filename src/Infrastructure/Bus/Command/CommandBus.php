<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Bus\Command;


/**
 * Interface CommandBus
 *
 * @package Bookee\Infrastructure\Bus\Command
 */
interface CommandBus
{
    public function run(Command $command): ?Response;
}