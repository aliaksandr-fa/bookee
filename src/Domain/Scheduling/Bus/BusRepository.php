<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Bus;

use Bookee\Domain\Scheduling\Driver\DriverId;


/**
 * Interface DriverRepository
 *
 * @package Bookee\Domain\Scheduling\Driver
 */
interface BusRepository
{
    public function getDrivableByDriver(DriverId $driverId): ?Bus;

    public function findById(BusId $busId): ?Bus;
}