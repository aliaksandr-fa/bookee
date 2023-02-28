<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowBookedTrips;


use Bookee\Infrastructure\Bus\Query\Response;

/**
 * Class ShowBookedTripsResponse
 *
 * @package Bookee\Application\Booking\ShowBookedTrips
 */
class ShowBookedTripsResponse implements Response
{
    /**
     * @param BookedTrip[] $trips
     */
    public function __construct(public array $trips) {}
}