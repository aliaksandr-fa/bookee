<?php declare(strict_types=1);

namespace Bookee\Domain\Booking;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class BookingCollection
 *
 * @package Bookee\Domain\Booking
 */
class BookingCollection extends ArrayCollection
{
    public function __construct(array $bookings = [])
    {
        parent::__construct($bookings);
    }

    public function current() : Booking
    {
        return parent::current();
    }

    public function offsetGet($offset) : Booking
    {
        return parent::offsetGet($offset);
    }
}