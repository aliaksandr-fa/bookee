<?php declare(strict_types=1);

namespace Bookee\Domain\Booking\Passenger;


/**
 * Class Passenger
 *
 * @package Bookee\Domain\Booking\Passenger
 */
class Passenger
{
    public function __construct(
        private readonly PassengerId $id,
        private readonly Name $name,
        private readonly Phone $phone
    ) {}

    public function id(): PassengerId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function phone(): Phone
    {
        return $this->phone;
    }
}