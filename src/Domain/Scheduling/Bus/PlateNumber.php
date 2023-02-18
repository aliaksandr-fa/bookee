<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Bus;


/**
 * Class PlateNumber
 *
 * @package Bookee\Domain\Scheduling\Bus
 */
class PlateNumber
{
    public function __construct(private readonly string $value) {}

    public function number(): string
    {
        return $this->value;
    }
}