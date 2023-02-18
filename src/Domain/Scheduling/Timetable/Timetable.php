<?php declare(strict_types=1);

namespace Bookee\Domain\Scheduling\Timetable;

use Bookee\Domain\Scheduling\RouteId;


/**
 * Class Timetable
 *
 * @package Bookee\Domain\Scheduling
 */
class Timetable
{
    public function __construct(
        private TimetableId $id,
        private RouteId $routeId,
        private CruisingDay $day,
        private Departures $departures
    ) {}

    /**
     * @return TimetableId
     */
    public function id(): TimetableId
    {
        return $this->id;
    }

    /**
     * @return CruisingDay
     */
    public function day(): CruisingDay
    {
        return $this->day;
    }

    /**
     * @return Departures
     */
    public function departures(): Departures
    {
        return $this->departures;
    }


}