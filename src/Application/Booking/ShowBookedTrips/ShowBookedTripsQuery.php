<?php declare(strict_types=1);

namespace Bookee\Application\Booking\ShowBookedTrips;

use Bookee\Infrastructure\Bus\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class ShowBookedTripsQuery
 *
 * @package Bookee\Application\Booking\ShowBookedTrips
 */
class ShowBookedTripsQuery implements Query
{
    public function __construct(
        #[Assert\Uuid]
        public string $passengerId
    ) {}
}