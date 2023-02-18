<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Driver;

use ArrayIterator;
use Bookee\Domain\Scheduling\Bus\BusId;

/**
 * Class DrivableBuses
 *
 * @package Bookee\Domain\Scheduling\Driver
 */
class DrivableBuses extends ArrayIterator
{
    public function __construct(BusId ...$buses)
    {
        parent::__construct($buses);
    }

    public function current() : BusId
    {
        return parent::current();
    }

    public function offsetGet($offset) : BusId
    {
        return parent::offsetGet($offset);
    }
}