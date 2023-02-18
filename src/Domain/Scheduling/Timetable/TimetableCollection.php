<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Timetable;

use ArrayIterator;


/**
 * Class TimetableCollection
 *
 * @package Bookee\Domain\Scheduling\Timetable
 */
class TimetableCollection extends ArrayIterator
{
    public function __construct(Timetable ...$timetable)
    {
        parent::__construct($timetable);
    }

    public function current(): Timetable
    {
        return parent::current();
    }

    public function offsetGet(mixed $key): Timetable
    {
        return parent::offsetGet($key);
    }
}