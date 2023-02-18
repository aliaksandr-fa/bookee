<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Driver;


/**
 * Class DriverContact
 *
 * @package Bookee\Domain\Scheduling
 */
class PhoneNumber
{
    public function __construct(protected readonly string $number) {}

    public function number(): string
    {
        return $this->number;
    }
}