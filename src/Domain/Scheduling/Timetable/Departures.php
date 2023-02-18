<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Timetable;

use ArrayIterator;


/**
 * Class Departures
 *
 * @package Bookee\Domain\Scheduling\Timetable
 */
class Departures extends ArrayIterator
{
    public function __construct(Time ...$time)
    {
        parent::__construct($time);
    }

    public function current() : Time
    {
        return parent::current();
    }

    public function offsetGet($offset) : Time
    {
        return parent::offsetGet($offset);
    }

    public function flatten(): array
    {
        return array_map(fn(Time $time) => $time->seconds(), $this->getArrayCopy());
    }
}