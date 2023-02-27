<?php declare(strict_types=1);

namespace Bookee\Infrastructure\Persistence\Booking;

use Bookee\Application\Booking\CreateTrip\TripsRepository as CreateTripRepository;
use Bookee\Domain\Booking\Trip;
use Bookee\Domain\Booking\TripId;
use Bookee\Domain\Booking\TripNotFoundException;
use Bookee\Domain\Booking\TripRepository;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class TripsRepositoryDoctrine
 *
 * @package Bookee\Infrastructure\Persistence
 */
class TripsRepositoryDoctrine implements TripRepository, CreateTripRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Trip $trip): void
    {
        $this->entityManager->persist($trip);
        $this->entityManager->flush();
    }

    public function getById(TripId $tripId): Trip
    {
        $trip = $this->entityManager->getRepository(Trip::class)->findOneBy([
            'id' => $tripId
        ]);

        if ($trip === null)
        {
            throw new TripNotFoundException("Trip $tripId not found.");
        }

        return $trip;
    }
}