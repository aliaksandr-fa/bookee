<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Driver;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Bus\BusId;


/**
 * Class Driver
 *
 * @package Bookee\Domain\Scheduling
 */
class Driver
{
    public function __construct(
        private DriverId $id,
        private string $name,
        private PhoneNumber $phoneNumber,
        private DrivableBuses $buses
    ) {}

    public function getCurrentBusId(): ?BusId
    {
        if ($this->hasDrivableBuses())
        {
            return $this->buses[0];
        }
        return null;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return DriverId
     */
    public function id(): DriverId
    {
        return $this->id;
    }

    /**
     * @return DrivableBuses
     */
    public function buses(): DrivableBuses
    {
        return $this->buses;
    }

    public function hasDrivableBuses(): bool
    {
        return $this->buses->count() > 0;
    }
}