<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Timetable;


/**
 * Class CruisingDay
 *
 * @package Bookee\Domain\Scheduling\Timetable
 */
enum CruisingDay: int {
    case MONDAY    = 1;
    case TUESDAY   = 2;
    case WEDNESDAY = 3;
    case THURSDAY  = 4;
    case FRIDAY    = 5;
    case SATURDAY  = 6;
    case SUNDAY    = 7;
}