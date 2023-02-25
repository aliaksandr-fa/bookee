<?php declare(strict_types=1);

namespace Bookee\Domain\Booking\Bus;


/**
 * Class BusPlateNumber
 *
 * @package Bookee\Domain\Booking\Bus
 */
class BusPlateNumber
{
    public function __construct(private readonly string $number) {}

    public function number(): string
    {
        return $this->number;
    }
}