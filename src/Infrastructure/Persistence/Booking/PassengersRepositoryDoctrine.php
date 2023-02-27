<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking;

use Bookee\Domain\Booking\Passenger\Passenger;
use Bookee\Domain\Booking\Passenger\PassengerId;
use Bookee\Domain\Booking\Passenger\PassengerNotFoundException;
use Bookee\Domain\Booking\Passenger\PassengerRepository;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class PassengersRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence\Booking
 */
class PassengersRepositoryDoctrine implements PassengerRepository
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Passenger $passenger): void
    {
        $this->entityManager->persist($passenger);
        $this->entityManager->flush();
    }

    public function getById(PassengerId $passengerId): Passenger
    {
        $passenger = $this->entityManager->getRepository(Passenger::class)->findOneBy([
            'id' => $passengerId
        ]);

        if ($passenger === null)
        {
            throw new PassengerNotFoundException("Passenger $passengerId not found.");
        }

        return $passenger;
    }
}