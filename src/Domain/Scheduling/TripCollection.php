<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling;

use ArrayIterator;


/**
 * Class TripCollection
 *
 * @package Bookee\Domain\Scheduling
 */
class TripCollection  extends ArrayIterator
{
    public function __construct(Trip ...$trips)
    {
        parent::__construct($trips);
    }

    public function current() : Trip
    {
        return parent::current();
    }

    public function offsetGet($offset) : Trip
    {
        return parent::offsetGet($offset);
    }
}