<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Driver;


/**
 * Interface DriverRepository
 *
 * @package Bookee\Domain\Scheduling\Driver
 */
interface DriverRepository
{
    public function findById(DriverId $driverId): ?Driver;
}