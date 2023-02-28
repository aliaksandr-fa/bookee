<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowBookedTrips;

use Bookee\Infrastructure\Bus\Query\QueryHandler;
use Bookee\Infrastructure\Bus\Query\Response;


/**
 * Class ShowBookedTripsHandler
 *
 * @package Bookee\Application\Booking\ShowBookedTrips
 */
class ShowBookedTripsHandler implements QueryHandler
{
    public function __construct(private readonly PassengerTripsFetcher $trips) {}

    public function __invoke(ShowBookedTripsQuery $query): ?Response
    {
        return new ShowBookedTripsResponse(
            $this->trips->findBookedTrips($query->passengerId)
        );
    }
}