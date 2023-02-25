<?php declare(strict_types=1);

namespace Bookee\Domain\Booking\Passenger;

use Webmozart\Assert\Assert;


/**
 * Class Name
 *
 * @package Bookee\Domain\Booking\Passenger
 */
class Name implements \Stringable
{
    private string $firstName;
    private ?string $lastName;

    public function __construct(string $firstName, ?string $lastName = null)
    {
        Assert::notEmpty($firstName, "Firstname cannot be empty.");

        $this->firstName = $firstName;
        $this->lastName  = $lastName;
    }

    public function __toString()
    {
        return !$this->lastName
            ? $this->firstName
            : sprintf('%s %s', $this->firstName, $this->lastName);
    }
}