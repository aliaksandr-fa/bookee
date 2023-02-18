<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Driver;


/**
 * Interface DriversPool
 *
 * @package Bookee\Domain\Scheduling\Driver
 */
interface DriversPool
{
    public function getAvailable(\DateTimeImmutable $forDate, ?int $count): DriverCollection;
}