<?php declare(strict_types=1);

namespace Bookee\Application\Booking\BookTrip;

use Bookee\Domain\Booking\Passenger\PassengerId;
use Bookee\Domain\Booking\Passenger\PassengerRepository;
use Bookee\Domain\Booking\TripId;
use Bookee\Domain\Booking\TripRepository;
use Bookee\Infrastructure\Bus\Command\CommandHandler;
use Bookee\Infrastructure\Bus\Command\Response;


/**
 * Class BookTripHandler
 *
 * @package Bookee\Application\Booking\BookTrip
 */
class BookTripHandler implements CommandHandler
{
    public function __construct(
        private readonly TripRepository $trips,
        private readonly PassengerRepository $passengers
    ){}

    public function __invoke(BookTripCommand $command): ?Response
    {
        $tripId      = new TripId($command->tripId);
        $passengerId = new PassengerId($command->passengerId);
        $bookedAt    = new \DateTimeImmutable();

        $trip      = $this->trips->getById($tripId);
        $passenger = $this->passengers->getById($passengerId);

        $trip->book($passenger->id(), $command->seats, $bookedAt);

        $this->trips->save($trip);

        return null;
    }
}