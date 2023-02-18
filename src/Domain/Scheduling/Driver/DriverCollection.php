<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Driver;

use ArrayIterator;


/**
 * Class DriverCollection
 *
 * @package Bookee\Domain\Scheduling\Driver
 */
class DriverCollection extends ArrayIterator
{
    public function __construct(Driver ...$drivers)
    {
        parent::__construct($drivers);
    }

    public function current() : Driver
    {
        return parent::current();
    }

    public function offsetGet($offset) : Driver
    {
        return parent::offsetGet($offset);
    }
}