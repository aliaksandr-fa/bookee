<?php declare(strict_types=1);

namespace Bookee\Application\Scheduling\CreateTrip;

use Bookee\Infrastructure\Bus\Command\Response;


/**
 * Class CreateTripResult
 *
 * @package Bookee\Application\Scheduling\CreateTrip
 */
class CreateTripResult implements Response
{
    public function __construct(public string $tripId) {}
}