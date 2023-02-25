<?php declare(strict_types=1);

namespace Bookee\Domain\Booking\Passenger;

use Webmozart\Assert\Assert;


/**
 * Class Phone
 *
 * @package Bookee\Domain\Booking\Passenger
 */
class Phone
{
    public function __construct(private string $value)
    {
        Assert::notEmpty($value, "Phone cannot be empty.");
    }

    public function value(): string
    {
        return $this->value;
    }
}