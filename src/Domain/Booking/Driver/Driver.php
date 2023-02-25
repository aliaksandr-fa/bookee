<?php declare(strict_types=1);

namespace Bookee\Domain\Booking\Driver;


/**
 * Class Driver
 *
 * @package Bookee\Domain\Booking\Driver
 */
class Driver
{
    public function __construct(
        private readonly string $name,
        private readonly string $phone
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function phone(): string
    {
        return $this->phone;
    }
}