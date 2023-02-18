<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\GetTimetable;

use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\Timetable\TimetableCollection;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class GetTimetableResponse
 *
 * @package Bookee\Application\Scheduling\GetTimetable
 */
class GetTimetableResponse implements Response
{
    public function __construct(
        public Route $route,
        public TimetableCollection $timetables
    ) {}
}