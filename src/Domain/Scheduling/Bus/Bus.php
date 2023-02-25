<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Bus;

use Webmozart\Assert\Assert;


/**
 * Class Vehicle
 *
 * @package Bookee\Domain\Scheduling
 */
class Bus
{
    public function __construct(
        private BusId $id,
        private PlateNumber $plateNumber,
        private int $seats
    ) {
        Assert::positiveInteger($this->seats);
    }

    public function seats(): int
    {
        return $this->seats;
    }

    public function id(): BusId
    {
        return $this->id;
    }

    public function plateNumber(): PlateNumber
    {
        return $this->plateNumber;
    }
}